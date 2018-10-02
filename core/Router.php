<?php

class Router {
  public static function route($url)  {
    //Define Controller
    $controller = (isset($url[0]) && $url[0]!='') ? ucwords($url[0]) : DEFAULT_CONTROLLER;
    $controller_name =$controller;
    array_shift($url);


    //Define Action
    $action = (isset($url[0]) && $url[0]!='') ? $url[0]. 'Action': DEFAULT_ACTION;
    $action_name =$action;
    array_shift($url);


    // Params
    $queryParams = $url;

    $dispatch = new $controller($controller_name,$action);
    if (method_exists($controller_name,$action)) {
      call_user_func_array([$dispatch,$action],$queryParams);
    }else {
      die(include (ROOT.DS.'App'.DS.'views'.DS.'404.php'));
      die("That method does not exist in the controller " . $controller_name);
    }


  }

}
