<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/
require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('model/connection/GoodnessOfMilk.php');
require_once ('model/valueObject/RegistrationVO.php');
require_once ('_helpers/SQL.php');

class RegistrationProxy extends Proxy implements IProxy {
	
	const NAME = "RegistrationProxy";
	private $database;
	private $connection;
	
	public function __construct() {
		parent::__construct(self::NAME, null);
		$this->database = GoodnessOfMilk::$database;
		$this->connection = GoodnessOfMilk::getConnection();
	}
	
	public function insert() { 
		if ((isset($_POST["facebook_id"])) && ($_POST["facebook_id"] != "")) {
			$session_id = sha1(rand());
			$insertSQL = sprintf("INSERT INTO Registration (facebook_id, session_id, name, email, mobile, city, country, lang, terms) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
					SQL::GetSQLValueString($_POST['facebook_id'], "text"),
					SQL::GetSQLValueString($session_id, "text"),
					SQL::GetSQLValueString($_POST['name'], "text"),
					SQL::GetSQLValueString($_POST['email'], "text"),
					SQL::GetSQLValueString($_POST['mobile'], "text"),
					SQL::GetSQLValueString($_POST['city'], "text"),
					SQL::GetSQLValueString($_POST['country'], "text"),
					SQL::GetSQLValueString($_POST['lang'], "text"),
					SQL::GetSQLValueString($_POST['terms'], "int"));
			
			$Result1 = mysql_query($insertSQL, $this->connection) or die(mysql_error());
			$this->facade->sendNotification(ApplicationFacade::REGISTRATION_INSERT, new RegistrationVO(mysql_insert_id(), $session_id));
		} else {
			$this->facade->sendNotification(ApplicationFacade::REGISTRATION_INSERT, null);
		}
	}
	
	public function exists() { 
		if ((isset($_POST["facebook_id"])) && ($_POST["facebook_id"] != "")) {
			$query_rsRegistration = sprintf("SELECT registration_id FROM Registration WHERE facebook_id = %s", SQL::GetSQLValueString($_POST['facebook_id'], "text"));
			$rsRegistration = mysql_query($query_rsRegistration, $this->connection) or die(mysql_error());
			$row_rsRegistration = mysql_fetch_assoc($rsRegistration);
			$totalRows_rsRegistration = mysql_num_rows($rsRegistration);
			
			if($totalRows_rsRegistration){
				$session_id = sha1(rand());
				
				$updateSQL = sprintf("UPDATE Registration SET session_id=%s WHERE registration_id=%s",
						SQL::GetSQLValueString($session_id, "text"),
						SQL::GetSQLValueString($row_rsRegistration['registration_id'], "int"));
			
				$Result1 = mysql_query($updateSQL, $this->connection) or die(mysql_error());
				$this->facade->sendNotification(ApplicationFacade::REGISTRATION_EXISTS, new RegistrationVO($row_rsRegistration['registration_id'], $session_id));
			} else {
				$this->facade->sendNotification(ApplicationFacade::REGISTRATION_EXISTS, null);
			}
			
		}
	}
	
	public function get_session_id($registration_id=0) {
		$query_rsUser = sprintf("SELECT session_id FROM Registration WHERE registration_id = %s", SQL::GetSQLValueString($registration_id, "int"));
		$rsUser = mysql_query($query_rsUser, $this->connection) or die(mysql_error());
		$row_rsUser = mysql_fetch_assoc($rsUser);
		$totalRows_rsUser = mysql_num_rows($rsUser);
		if($totalRows_rsUser > 0) {
			return $row_rsUser['session_id'];
		}
	}
	
}
?>