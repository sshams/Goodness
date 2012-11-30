<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/
require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('ApplicationFacade.php');
require_once ('view/component/Registration.php');

class RegistrationMediator extends Mediator {
	const NAME = "RegistrationMediator";
	
	public function __construct(Registration $registration) {
		parent::__construct(self::NAME, $registration);
	}
	
	public function listNotificationInterests() {
		return array(
				ApplicationFacade::REGISTRATION_INSERT,
				ApplicationFacade::REGISTRATION_EXISTS
		);
	}
	
	public function handleNotification(INotification $notification){
		switch($notification->getName()){
			case ApplicationFacade::REGISTRATION_INSERT:
				$this->viewComponent->insert($notification->getBody());
				break;
			case ApplicationFacade::REGISTRATION_EXISTS:
				$this->viewComponent->exists($notification->getBody());
				break;
		}
	}
	
}

?>