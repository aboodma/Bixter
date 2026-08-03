<?php

declare(strict_types=1);

class Tools extends Controller
{
    public function __construct(string $controller, string $action)
    {
        parent::__construct($controller, $action);
    }

    public function indexAction(): void
    {
        $this->view->render('tools/index');
    }

    public function firstAction(): void
    {
        $this->view->render('tools/first');
    }

    public function secondAction(): void
    {
        $this->view->render('tools/secon');
    }

    public function thirdAction(): void
    {
        $this->view->render('tools/third');
    }
}
