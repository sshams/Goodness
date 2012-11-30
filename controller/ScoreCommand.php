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
require_once ('_libs/SimpleCrypt.php');
require_once ('model/ScoreProxy.php');
require_once ('view/component/Score.php');
require_once ('view/mediator/ScoreMediator.php');

class ScoreCommand extends SimpleCommand { 
	
	public function execute(INotification $notification){
		
		switch($this->facade->retrieveProxy(URIProxy::NAME)->getData()){
			
			case URIProxy::SCORE:
			case URIProxy::SCORE_INSERT:
				break;
				
			case URIProxy::DECACHE: //dodge
				CacheProxy::uncache(URIProxy::SCORE_LIST);
				$this->facade->registerMediator(new ScoreMediator(new Score()));
				$this->facade->registerProxy(new ScoreProxy());
				$this->facade->retrieveProxy(ScoreProxy::NAME)->insert();
				break;
			
			case URIProxy::SCORE_LIST:
				header('Content-Type: text/xml; charset=UTF-8');
				if(ApplicationFacade::CACHING){
					$this->facade->registerProxy(new CacheProxy());
					$cacheProxy = $this->facade->retrieveProxy(CacheProxy::NAME);
					if($cacheProxy->cache_exists(URIProxy::SCORE_LIST)){
						$this->facade->registerMediator(new CacheMediator(new Cache()));
						$cacheProxy->get_cache(URIProxy::SCORE_LIST);
						return;
					}
				}
				
				$this->facade->registerProxy(new ScoreProxy());
				$this->facade->registerMediator(new ScoreMediator(new Score()));
				$this->facade->retrieveProxy(ScoreProxy::NAME)->records();
				break;
				
			case URIProxy::SCORE_BEST:
				$this->facade->registerProxy(new ScoreProxy());
				$this->facade->registerMediator(new ScoreMediator(new Score()));
				$this->facade->retrieveProxy(ScoreProxy::NAME)->best();
				break;
				
			case URIProxy::SCORE_RANK:
				header('Content-Type: text/xml; charset=UTF-8');
				$this->facade->registerProxy(new ScoreProxy());
				$this->facade->registerMediator(new ScoreMediator(new Score()));
				$this->facade->retrieveProxy(ScoreProxy::NAME)->rank();
				break;
				
			case URIProxy::SCORES_TOTAL:
				$this->facade->registerMediator(new ScoreMediator(new Score()));
				$this->facade->registerProxy(new ScoreProxy());
				$this->facade->retrieveProxy(ScoreProxy::NAME)->totalScores();
				break;
				
			case URIProxy::SCORE_UPLOAD:
				$this->facade->registerProxy(new ScoreProxy());
				$this->facade->retrieveProxy(ScoreProxy::NAME)->upload();
				break;
		}
	}
	
}
?>
