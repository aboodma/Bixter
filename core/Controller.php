<?php

declare(strict_types=1);

namespace Bixter\Core;

class Controller extends Application
{
    protected string $_controller;
    protected string $_action;
    public View $view;
    public Request $request;

    public function __construct(string $controller, string $action)
    {
        parent::__construct();
        $this->_controller = $controller;
        $this->_action = $action;
        $this->view = new View();
        $this->request = new Request();
    }
}
