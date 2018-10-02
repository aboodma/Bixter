<?php 

 /**
  * 
  */
 class Tools extends controller
 {
 	
 	function __construct($controller,$action)
 	{
 		parent::__construct($controller,$action);
 		$this->view->setLayout('default');
 	}


 	public function indexAction()
 	{
 		$this->view->render('tools/index');
 	}
 	public function firstAction()
 	{
 		$this->view->render('tools/first');
 	}
 	public function secondAction()
 	{
 		$this->view->render('tools/secon');
 	}
 	public function thirdAction()
 	{
 		$this->view->render('tools/third');
 	}
 }
