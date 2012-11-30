<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/


class Time {
	
	public static function getTime() {
		$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];
		return $mtime;
	}

}

?>