<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/

class Language {
	public static function is_arabic($string){
		return preg_match("/\p{Arabic}/u", $string);
	}
}

?>