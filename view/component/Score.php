<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/
interface ScoreDelegate {
	function cache($content);
}

require_once ('model/valueObject/ScoreVO.php');
require_once ('_helpers/Parser.php');

class Score {
	
	public $delegate;
	
	public function insert($success) {
		if($success){
			echo file_get_contents("view/template/success.txt");
		} else {
			echo file_get_contents("view/template/failure.txt");
		}
	}
	
	public function records($scoreVOs) {
		//echo file_get_contents("view/template/leaderboard.txt");
		//return;
		ob_start();
		
		echo "<scores>";
		foreach ($scoreVOs as $key){
			echo Parser::parse(file_get_contents("view/template/score.txt"), $key);
		}
		echo "</scores>";
		
		$this->delegate->cache(ob_get_contents());
		ob_end_flush();
	}
	
	public function best($scoreVO){
		//echo "<scores></scores>";
		//return;
		
		if($scoreVO){
			echo "<scores>" . Parser::parse(file_get_contents("view/template/score.txt"), $scoreVO) . "</scores>";
		} else {
			echo "<scores></scores>";
		}
	}
	
	public function scores_total($total) {
		echo "total=" . $total;
	}
	
	public function rank($scoreVO){
		$this->best($scoreVO);
	}
	
}

?>