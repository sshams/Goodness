<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/


class Parser {

	public static function parse($template, $data){
		foreach ($data as $key => $value){
			if(is_array($value)) {
				
			} else {
				$template = str_replace("{". $key . "}", $value, $template);
			}
		}
		return $template;
	}
	
}

?>