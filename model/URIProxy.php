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

class URIProxy extends Proxy implements IProxy {
	
	const NAME = "URIProxy";
	
	const HOME = '/';
	
	const REGISTRATION = '/registration';
	const REGISTRATION_INSERT = "/registration/insert";
	const REGISTRATION_EXISTS = "/registration/exists";
	
	const SCORE = "/score";
	const SCORE_INSERT = "/score/insert";
	const DECACHE = "/decache";
	
	const SCORE_LIST = "/score/list";
	const SCORE_BEST = "/score/best";
	const SCORE_RANK = "/score/rank";
	const SCORE_UPLOAD = "/score/upload";
	
	const SCORES_TOTAL = "/scores/total";
	
	public function __construct() {
		parent::__construct(self::NAME, isset($_SERVER['PATH_INFO']) ? rtrim($_SERVER['PATH_INFO'], "/") : self::HOME);
	}
	
}
?>