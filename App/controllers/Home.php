<?php

declare(strict_types=1);

class Home extends Controller
{
    public function __construct(string $controller, string $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction(): void
    {
        $this->view->render('home/index');
    }
}
