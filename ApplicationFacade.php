<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/
require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('controller/StartupCommand.php');
require_once ('controller/RegistrationCommand.php');
require_once ('controller/ScoreCommand.php');

class ApplicationFacade extends Facade implements IFacade {
	
	const CACHING = false;
	const CACHE_HIT = "cacheHit";
	
	const STARTUP = 'startup';
	const REGISTRATION = 'registration';
	const REGISTRATION_INSERT = "registrationInsert";
	const REGISTRATION_EXISTS = "registrationExists";
	
	const SCORE = "score";
	const SCORE_INSERT = "scoreInsert";
	const SCORE_LIST = "scoreList";
	const SCORE_BEST = "scoreBest";
	const SCORE_RANK = "scoreRank";
	const SCORES_TOTAL = "scoresTotal";
	
	public static function getInstance(){
		if(parent::$instance == null){
			parent::$instance = new ApplicationFacade();
		}
		return parent::$instance;
	}
	
	protected function initializeController() {
		parent::initializeController();
		$this->registerCommand(self::STARTUP, 'StartupCommand');
		$this->registerCommand(self::REGISTRATION, 'RegistrationCommand');
		$this->registerCommand(self::SCORE, 'ScoreCommand');
	}
	
	public function startup($params=null) {
		$this->sendNotification(self::STARTUP, $params);
	}
	
}

?>