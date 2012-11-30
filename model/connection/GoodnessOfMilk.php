<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/


class GoodnessOfMilk {

	public static $database = "GoodnessOfMilk";
  	private static $hostname = "127.0.0.1";
	private static $username = "root";
	private static $password = "";
	private static $connection; 

	public static function getConnection() {
		if(!isset(self::$connection)){
			self::$connection = mysql_connect(self::$hostname, self::$username, self::$password) or trigger_error(mysql_error(), E_USER_ERROR);
			mysql_select_db(self::$database, self::$connection);
			//mysql_query("SET NAMES utf8");
		}
		return self::$connection;
	}
}

?>