<?php

/*
* This File Made By Abdulrahman Mardini
* In This File Will SEPARAT Url Containe (Controller,Action,Prams)
* And Will Include First File Bootstrap.php (This File Just Auto load Not Bootstrap Framework)
* DS Pram IS DIRECTORY_SEPARATOR
* ROOT Is The Local File 
*/
  session_start();
  define('DS',DIRECTORY_SEPARATOR);
  define('ROOT',dirname(__FILE__) );
    $url = isset($_SERVER['PATH_INFO'])? explode('/',ltrim($_SERVER['PATH_INFO'],'/')) : [];
    require_once(ROOT . DS . 'core'. DS .'bootstrap.php');
