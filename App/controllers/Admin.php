<?php


/**
 *
 */
class Admin extends Controller
{
  public function __construct($controller,$action)
  {
    parent::__construct($controller,$action);
    $this->view->setLayout('default');
  }

public function indexAction()
{

  $this->view->render('admin/index');
}
public function loginAction()
{

$this->view->render('admin/login');

}

public function UserAction($id)
{

  echo $id;
}
public function DeleteAction($id)
{

  echo $id;
}

}
