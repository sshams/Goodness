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
require_once ('model/URIProxy.php');
require_once ('view/mediator/CacheMediator.php');
require_once ('view/component/Cache.php');
require_once ('model/CacheProxy.php');

class StartupCommand extends SimpleCommand implements ICommand { //routing
	
	public function execute(INotification $notification){
		
		$this->facade->registerProxy(new URIProxy());
		
		switch($this->facade->retrieveProxy(URIProxy::NAME)->getData()){
			
			case URIProxy::HOME:
				header('Expires: Thu, 01 Jan 1970 00:00:00 GMT, -1');
				header('Cache-Control: no-cache, no-store, must-revalidate');
				header('Pragma: no-cache');
				header('Content-type: text/html; charset=UTF-8') ;
				echo file_get_contents("index.html");
				break;
					
			case URIProxy::REGISTRATION:
			case URIProxy::REGISTRATION_INSERT:
			case URIProxy::REGISTRATION_EXISTS:
				$this->facade->sendNotification(ApplicationFacade::REGISTRATION);
				break;
		
			case URIProxy::SCORE:
			case URIProxy::SCORE_INSERT:
			case URIProxy::SCORE_LIST: 
			case URIProxy::SCORE_BEST:
			case URIProxy::SCORE_RANK:
			case URIProxy::SCORES_TOTAL:
			case URIProxy::SCORE_UPLOAD:
			case URIProxy::DECACHE: //dodge
				$this->facade->sendNotification(ApplicationFacade::SCORE);
				break;
				
			default:
				echo " 404 Not Found!";
				break;
		}
	}
}
?>