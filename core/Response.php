<?php

declare(strict_types=1);

class Response
{
    private string $_content = '';
    private int $_status = 200;
    private array $_headers = [];

    public function __construct(string $content = '', int $status = 200)
    {
        $this->_content = $content;
        $this->_status = $status;
    }

    public function setContent(string $content): self
    {
        $this->_content = $content;
        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->_status = $status;
        return $this;
    }

    public function setHeader(string $name, string $value): self
    {
        $this->_headers[$name] = $value;
        return $this;
    }

    public function json(array $data, int $status = 200): self
    {
        $this->_content = json_encode($data, JSON_PRETTY_PRINT);
        $this->_status = $status;
        $this->setHeader('Content-Type', 'application/json');
        return $this;
    }

    public function send(): void
    {
        http_response_code($this->_status);
        foreach ($this->_headers as $name => $value) {
            header("{$name}: {$value}");
        }
        echo $this->_content;
    }
}
