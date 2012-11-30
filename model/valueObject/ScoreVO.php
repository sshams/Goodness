<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/

class ScoreVO {
	public $rank;
	public $name;
	public $facebook_id;
	public $total;
	
	function __construct($rank, $name, $facebook_id, $total){
		$this->rank = $rank;
		$this->name = $name;
		$this->facebook_id = $facebook_id;
		$this->total = $total;
	}
}

?>