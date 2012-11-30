<?php
require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('ApplicationFacade.php');

class CacheProxy extends Proxy implements IProxy {
	
	const NAME = "CacheProxy";
	const PATH = "cache";
	const FILENAME = "/cache.txt";
	
	public function __construct() {
		parent::__construct(self::NAME, null);
	}
	
	public function cache($uri, $content){
		if(!is_dir(self::PATH . $uri)){
			
			mkdir(self::PATH . $uri, 0755, true);
		}
		file_put_contents(self::PATH . $uri . self::FILENAME, $content);
	}
	
	public function get_cache($uri){
		$this->facade->sendNotification(ApplicationFacade::CACHE_HIT, file_get_contents(self::PATH . $uri . self::FILENAME));
	}
	
	public function cache_exists($uri){
		return file_exists(self::PATH . $uri . self::FILENAME);
	}
	
	public static function uncache($uri){ 
		if(file_exists(self::PATH . $uri . self::FILENAME)) {
			unlink(self::PATH . $uri . self::FILENAME);
		}
	}
}

?>