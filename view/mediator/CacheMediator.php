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
require_once ('view/component/Cache.php');

class CacheMediator extends Mediator implements IMediator {
	
	const NAME = "CacheMediator";
	
	public function __construct($cache){
		parent::__construct(self::NAME, $cache);
	}
	
	public function listNotificationInterests() {
		return array(ApplicationFacade::CACHE_HIT);
	}
	
	public function handleNotification(INotification $notification) {
		switch($notification->getName()){
			case ApplicationFacade::CACHE_HIT:
				$this->viewComponent->output($notification->getBody());
				break;
		}
	}
}

?>