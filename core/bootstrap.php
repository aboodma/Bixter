<?php

/*
* This IS First Include File At Project
* Will Include The Config To Take The Prams Form config
* After Wil Include The Helpers
* And AutoLoad PHP Function Will Call The Classes By $className Param
* And Will Require The Router To make Routes
*/
    // load config and helper functions

    require_once(ROOT . DS . 'config' . DS . 'config.php');
    require_once(ROOT . DS . 'App' . DS . 'lib' . DS . 'helpers' . DS . 'functions.php');

// Autoload classes

 spl_autoload_register(function ($className){
            if (file_exists(ROOT . DS . 'core' .DS . $className . '.php')) {
              require_once (ROOT . DS . 'core' .DS . $className . '.php');
            }elseif (file_exists(ROOT . DS . 'App' .DS . 'controllers' .DS . $className . '.php')) {
              require_once (ROOT . DS . 'App' .DS . 'controllers' .DS . $className . '.php');
            }elseif (file_exists(ROOT . DS . 'App' .DS . 'models' .DS . $className . '.php')) {
              require_once (ROOT . DS . 'App' .DS . 'models' .DS . $className . '.php');
            }
          });

// Route request
Router::route($url);
