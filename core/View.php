<?php

declare(strict_types=1);

namespace Bixter\Core;

class View
{
    protected string $_head = '';
    protected string $_body = '';
    protected string $_siteTitle;
    protected string $_outputBuffer = '';
    protected string $_layout = DEFAULT_LAYOUT;
    protected array $_data = [];

    public function __construct()
    {
        $this->_siteTitle = SITE_TITLE;
    }

    public function assign(string $key, mixed $value): void
    {
        $this->_data[$key] = $value;
    }

    public function render(string $viewName, ?string $layout = null): void
    {
        $layout = $layout ?? $this->_layout;

        $viewPath = ROOT . DS . 'App' . DS . 'views' . DS . str_replace('/', DS, $viewName) . '.php';
        if (!file_exists($viewPath)) {
            die('The view ' . $viewName . ' was not found.');
        }

        extract($this->_data, EXTR_OVERWRITE);
        include $viewPath;

        $layoutPath = ROOT . DS . 'App' . DS . 'views' . DS . 'layouts' . DS . $layout . '.php';
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            echo $this->content('body');
        }
    }

    public function renderPartial(string $viewName): void
    {
        $viewPath = ROOT . DS . 'App' . DS . 'views' . DS . str_replace('/', DS, $viewName) . '.php';
        if (!file_exists($viewPath)) {
            die('The view ' . $viewName . ' was not found.');
        }
        extract($this->_data, EXTR_OVERWRITE);
        include $viewPath;
    }

    public function content(string $type): string
    {
        if ($type === 'head') {
            return $this->_head;
        }
        if ($type === 'body') {
            return $this->_body;
        }
        return '';
    }

    public function start(string $type): void
    {
        $this->_outputBuffer = $type;
        ob_start();
    }

    public function end(): void
    {
        if ($this->_outputBuffer === 'head') {
            $this->_head = ob_get_clean() ?: '';
        } elseif ($this->_outputBuffer === 'body') {
            $this->_body = ob_get_clean() ?: '';
        } else {
            ob_end_clean();
            die('Output buffer not started.');
        }
        $this->_outputBuffer = '';
    }

    public function siteTitle(): string
    {
        return $this->_siteTitle;
    }

    public function setSiteTitle(string $title): void
    {
        $this->_siteTitle = $title;
    }

    public function setLayout(string $path): void
    {
        $this->_layout = $path;
    }

    public function __get(string $key): mixed
    {
        return $this->_data[$key] ?? null;
    }
}
