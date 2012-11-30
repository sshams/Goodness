<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/
class RegistrationVO {
	
	public $registration_id;
	public $session_id;
	
	function __construct($registration_id, $session_id) {
		$this->registration_id = $registration_id;
		$this->session_id = $session_id;
	}
	
	public function __toString() {
		return "registration_id: " . $this->registration_id . " session_id: " . $this->session_id;
	}
}

?>