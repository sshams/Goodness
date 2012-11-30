<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/
require_once ('model/valueObject/RegistrationVO.php');
require_once ('_helpers/Parser.php');

class Registration {

	public function insert(RegistrationVO $registrationVO=null){
		if($registrationVO){
			echo Parser::parse(file_get_contents("view/template/registration.txt"), $registrationVO);
		} else {
			echo file_get_contents("view/template/failure.txt");
		}
	}
	
	public function exists(RegistrationVO $registrationVO=null){
		if($registrationVO){
			echo Parser::parse(file_get_contents("view/template/registration.txt"), $registrationVO);
		} else {
			echo file_get_contents("view/template/failure.txt");
		}
	}

}

?>