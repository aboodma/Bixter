<?php
/*
*This File Made By Abdulrahman Mardini
*
*/

/*Here Some Configs You can Change It */



define('SITE_TITLE', 'NEW BIXTER'); // @Param SITE_TITLE if no SITE_TITLE Will Use The default SITE_TITLE
define('PROOT', '/bixter/'); // @Param PROOT if no PROOT Will Use The default PROOT
define('DEBUG',true); // @Param DEBUG if DEBUG Value True Will Show Errors If False Will Hide All Errors




/*Here Some Configs You Can't Change It  (This Config Just Developers Can Change it)*/



define('DEFAULT_LAYOUT', 'default'); // @Param DEFAULT_LAYOUT if no layout Will Use The default layout
define('DEFAULT_CONTROLLER', 'Home'); // @Param DEFAULT_CONTROLLER if no Controller Will Use The default DEFAULT_CONTROLLER
define('DEFAULT_ACTION', 'indexAction'); // @Param DEFAULT_ACTION if no Action Will Use The default DEFAULT_ACTION
define('404PAGE', ROOT.DS.'App'.DS.'views'.DS.'404.php'); // @Param 404PAGE This Soruce For The 404 Error Page




/* DataBase Params*/



define('DBUSER', 'root'); // DBUSER This Your Database User Name Default is Root
define('DBPASSWORD', ''); // DBPASSWORD This Your Database Password Default is none''
define('DBSERVER', 'Localhost'); // DBSERVER This Your Database Server Default is Localhost
define('DBPORT', '8080'); // DBPORT This Your Database Server Port Default is 8080
define('DBNAME', ''); // DBNAME This Your Database Name
