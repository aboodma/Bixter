<?php

/**
 *
 */
class View {
  protected $_head , $_body, $_stieTitle=SITE_TITLE , $_outputBuffer , $_layout = DEFAULT_LAYOUT;

  public function __construct()
  {

  }
  public function render($viewName)
  {
    // This function Have @Paramiter $viewName Will Return The View Page
    $viewAry= explode ('/',$viewName);
    $viewString = implode(DS,$viewAry);
    if (file_exists(ROOT.DS.'App'.DS.'views'.DS.$viewString.'.php')) {
      include (ROOT.DS.'App'.DS.'views'.DS.$viewString.'.php');
       include (ROOT.DS.'App'.DS.'views'.DS.'layouts'.DS.$this->_layout.'.php');
    }else {
      die("the view ".$viewName. "NOT FOUND!!!");
    }
  }
  public function content($type)
  {
    // This function Have @Paramiter $type Will Return The Content Using type  
    if ($type=='head') {
      return $this->_head;
    }elseif ($type=='body') {
      return $this->_body;
    }
    return false;
  }

  public function start($type)
  {
    $this->_outputBuffer=$type;
    ob_start();
  }
  public function end()
  {
    if ($this->_outputBuffer == 'head') {
      $this->_head=ob_get_clean();
    }elseif ($this->_outputBuffer == 'body') {
      $this->_body=ob_get_clean();
    }else {
      die("you should use start first start function not found");
    }

  }
  public function siteTitle()
  {

    return $this->_stieTitle;
  }
  public function setSiteTitle($title)
  {
    $this->_stieTitle = $title;
  }
  public function setLayout($path)
  {
    $this->_layout= $path;
  }


}
