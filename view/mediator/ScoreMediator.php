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
require_once ('view/component/Score.php');
require_once ('model/URIProxy.php');
require_once ('model/CacheProxy.php');

class ScoreMediator extends Mediator implements IMediator, ScoreDelegate {
	
	const NAME = "ScoreMediator";
	
	public function __construct(Score $score) {
		parent::__construct(self::NAME, $score);
	}
	
	public function onRegister(){
		$this->viewComponent->delegate = $this;
	}
	
	public function listNotificationInterests() {
		return array(
				ApplicationFacade::SCORE_INSERT,
				ApplicationFacade::SCORE_LIST,
				ApplicationFacade::SCORE_BEST,
				ApplicationFacade::SCORE_RANK,
				ApplicationFacade::SCORES_TOTAL
		);
	}
	
	public function handleNotification(INotification $notification){
		switch($notification->getName()){
			case ApplicationFacade::SCORE_INSERT:
				$this->viewComponent->insert($notification->getBody());
				break;
			case ApplicationFacade::SCORE_LIST:
				$this->viewComponent->records($notification->getBody());				
				break;
			case ApplicationFacade::SCORE_BEST:
				$this->viewComponent->best($notification->getBody());
				break;
			case ApplicationFacade::SCORE_RANK:
				$this->viewComponent->rank($notification->getBody());
				break;
			case ApplicationFacade::SCORES_TOTAL:
				$this->viewComponent->scores_total($notification->getBody());
				break;
		}
	}
	
	public function cache($content){
		if(ApplicationFacade::CACHING){
			$this->facade->retrieveProxy(CacheProxy::NAME)->cache(URIProxy::SCORE_LIST, $content);
		}
	}
	
}

?>