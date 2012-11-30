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
require_once ('model/RegistrationProxy.php');
require_once ('view/mediator/RegistrationMediator.php');
require_once ('view/component/Registration.php');

class RegistrationCommand extends SimpleCommand {
	
	public function execute(INotification $notification){
		
		$this->facade->registerProxy(new RegistrationProxy());
		$this->facade->registerMediator(new RegistrationMediator(new Registration()));
		
		switch($this->facade->retrieveProxy(URIProxy::NAME)->getData()){
			
			case URIProxy::REGISTRATION:
			case URIProxy::REGISTRATION_INSERT:
				$this->facade->retrieveProxy(RegistrationProxy::NAME)->insert();
				break;
			
			case URIProxy::REGISTRATION_EXISTS:
				$this->facade->retrieveProxy(RegistrationProxy::NAME)->exists();
				break;
		}
		
	}
	
}

?>