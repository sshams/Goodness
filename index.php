<?php
//http://developer.loftdigital.com/blog/php-utf-8-cheatsheet
//http://ferdychristant.com/blog/articles/DOMM-7LDBXK
//require_once ('_helpers/Time.php');
require_once '_libs/PureMVC_PHP_1_0_2.php';
require_once 'ApplicationFacade.php';

//$start = Time::getTime(); 

ini_set("default_charset", "UTF-8");
ApplicationFacade::getInstance()->startup();

//echo "<!-- " . (Time::getTime() - $start)  . "-->";
?>