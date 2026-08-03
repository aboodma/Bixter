<?php

declare(strict_types=1);

namespace Bixter\Core;

class Validator
{
    private array $_data;
    private array $_rules;
    private array $_errors = [];
    private array $_messages = [];
    private array $_custom = [];

    public function __construct(array $data, array $rules, array $messages = [])
    {
        $this->_data = $data;
        $this->_rules = $rules;
        $this->_messages = $messages;
    }

    public static function make(array $data, array $rules, array $messages = []): self
    {
        return new self($data, $rules, $messages);
    }

    public function passes(): bool
    {
        $this->_errors = [];

        foreach ($this->_rules as $field => $ruleString) {
            $rules = explode('|', $ruleString);
            foreach ($rules as $rule) {
                if ($rule === '') {
                    continue;
                }
                $this->validateRule($field, $rule);
            }
        }

        return empty($this->_errors);
    }

    public function fails(): bool
    {
        return !$this->passes();
    }

    public function errors(): array
    {
        return $this->_errors;
    }

    public function first(string $field): ?string
    {
        return $this->_errors[$field][0] ?? null;
    }

    public function validated(): array
    {
        $validated = [];
        foreach (array_keys($this->_rules) as $field) {
            $validated[$field] = $this->_data[$field] ?? null;
        }
        return $validated;
    }

    public function customRule(string $name, \Closure $callback): self
    {
        $this->_custom[$name] = $callback;
        return $this;
    }

    private function validateRule(string $field, string $rule): void
    {
        $parts = explode(':', $rule, 2);
        $ruleName = $parts[0];
        $params = isset($parts[1]) ? explode(',', $parts[1]) : [];

        $value = $this->_data[$field] ?? null;

        $error = null;

        switch ($ruleName) {
            case 'required':
                if ($value === null || $value === '' || (is_array($value) && empty($value))) {
                    $error = 'The ' . $field . ' field is required.';
                }
                break;

            case 'email':
                if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $error = 'The ' . $field . ' must be a valid email address.';
                }
                break;

            case 'min':
                if ($value !== null && $value !== '') {
                    $length = (int) ($params[0] ?? 0);
                    if (is_string($value) && strlen($value) < $length) {
                        $error = "The {$field} must be at least {$length} characters.";
                    } elseif (is_numeric($value) && (float) $value < $length) {
                        $error = "The {$field} must be at least {$length}.";
                    }
                }
                break;

            case 'max':
                if ($value !== null && $value !== '') {
                    $length = (int) ($params[0] ?? PHP_INT_MAX);
                    if (is_string($value) && strlen($value) > $length) {
                        $error = "The {$field} must not exceed {$length} characters.";
                    } elseif (is_numeric($value) && (float) $value > $length) {
                        $error = "The {$field} must not exceed {$length}.";
                    }
                }
                break;

            case 'string':
                if ($value !== null && $value !== '' && !is_string($value)) {
                    $error = 'The ' . $field . ' must be a string.';
                }
                break;

            case 'numeric':
                if ($value !== null && $value !== '' && !is_numeric($value)) {
                    $error = 'The ' . $field . ' must be numeric.';
                }
                break;

            case 'integer':
                if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_INT)) {
                    $error = 'The ' . $field . ' must be an integer.';
                }
                break;

            case 'url':
                if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                    $error = 'The ' . $field . ' must be a valid URL.';
                }
                break;

            case 'in':
                if ($value !== null && $value !== '' && !in_array((string) $value, $params, true)) {
                    $error = 'The ' . $field . ' must be one of: ' . implode(', ', $params) . '.';
                }
                break;

            case 'confirmed':
                $confirmation = $this->_data[$field . '_confirmation'] ?? null;
                if ($value !== $confirmation) {
                    $error = 'The ' . $field . ' confirmation does not match.';
                }
                break;

            case 'regex':
                $pattern = $params[0] ?? '';
                if ($value !== null && $value !== '' && !preg_match($pattern, (string) $value)) {
                    $error = 'The ' . $field . ' format is invalid.';
                }
                break;

            case 'unique':
                if ($value !== null && $value !== '') {
                    $table = $params[0] ?? '';
                    $column = $params[1] ?? $field;
                    $qb = Application::$db->table($table)->where($column, $value);
                    if (isset($params[2], $params[3])) {
                        $qb->where($params[2], $params[3], '!=');
                    }
                    if ($qb->first()) {
                        $error = 'The ' . $field . ' has already been taken.';
                    }
                }
                break;

            case 'exists':
                if ($value !== null && $value !== '') {
                    $table = $params[0] ?? '';
                    $column = $params[1] ?? $field;
                    if (!Application::$db->table($table)->where($column, $value)->first()) {
                        $error = 'The selected ' . $field . ' is invalid.';
                    }
                }
                break;

            default:
                if (isset($this->_custom[$ruleName])) {
                    $result = ($this->_custom[$ruleName])($value, $this->_data, $params);
                    if ($result !== true) {
                        $error = is_string($result) ? $result : 'The ' . $field . ' is invalid.';
                    }
                }
                break;
        }

        if ($error !== null) {
            $messageKey = $field . '.' . $ruleName;
            $error = $this->_messages[$messageKey] ?? $error;
            $this->_errors[$field][] = $error;
        }
    }
}
