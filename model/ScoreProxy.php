<?php
/**
*
* @author Saad Shams :: sshams@live.com
*
* Copy, reuse is prohibited.
* 
*/

require_once ('_libs/PureMVC_PHP_1_0_2.php');
require_once ('model/connection/GoodnessOfMilk.php');
require_once ('model/valueObject/ScoreVO.php');
require_once ('_helpers/SQL.php');
require_once ('_libs/SimpleCrypt.php');

class ScoreProxy extends Proxy implements IProxy {
	const NAME = "ScoreProxy";
	
	private $database;
	private $connection;
	
	public function __construct() {
		parent::__construct(self::NAME, null);
		$this->database = GoodnessOfMilk::$database;
		$this->connection = GoodnessOfMilk::getConnection();
	}
	
	public function insert() {
		if(isset($_POST['decache']) && $_POST['decache'] != ""){
			$nab = 0; $rts = 0; $gge = 0; $orb = 0; $rac = 0; $iar = 0; $lotat = 0; 
			$banana = 0; $strawberry = 0; $egg=0; $broccoli=0; $carrot=0; $rainbow=0; $total=0; $time=0; $registration_id=0; $smapc=0;
			
			$simpleCrypt = new SimpleCrypt();
			parse_str($simpleCrypt->decrypt($_POST['decache'], "5151\"5151#5151$5151%5151&5151'52(5252)5252*5252+52,5252-5252.5252/525205252152"));
			
			$banana = substr($nab, 3);
			$strawberry = substr($rts, 3);
			$egg = substr($gge, 3);
			$broccoli = substr($orb, 3);
			$carrot = substr($rac, 3);
			$rainbow = substr($iar, 3);
			$total = substr($lotat, 3);
			
			$insertSQL = sprintf("INSERT INTO Score (banana, strawberry, egg, broccoli, carrot, rainbow, total, time, registration_id, total_fake, ip) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					SQL::GetSQLValueString($banana, "int"),
					SQL::GetSQLValueString($strawberry, "int"),
					SQL::GetSQLValueString($egg, "int"),
					SQL::GetSQLValueString($broccoli, "int"),
					SQL::GetSQLValueString($carrot, "int"),
					SQL::GetSQLValueString($rainbow, "int"),
					SQL::GetSQLValueString($total, "int"),
					SQL::GetSQLValueString($time, "int"),
					SQL::GetSQLValueString($registration_id, "int"),
					SQL::GetSQLValueString(isset($_POST['total']) ? $_POST['total'] : NULL, "int"),
					SQL::GetSQLValueString($_SERVER['REMOTE_ADDR'] . ", " . $_SERVER['HTTP_REFERER'] . ", " . $_SERVER['HTTP_USER_AGENT'], "text"));
				
			$Result1 = mysql_query($insertSQL, $this->connection) or die(mysql_error());
			
			$this->facade->sendNotification(ApplicationFacade::SCORE_INSERT, 1);			
		} else {
			$this->facade->sendNotification(ApplicationFacade::SCORE_INSERT, 0);
		}
	}
	
	public function upload() {
		if(isset($GLOBALS['HTTP_RAW_POST_DATA']) && isset($_GET['registration_id']) && $_GET['registration_id'] != "") {
			$path = "_images/";
			if(!is_dir($path . $_GET['registration_id'])){
				mkdir($path . $_GET['registration_id'], 0755, true);
			}
			$fp = fopen($path . $_GET['registration_id'] . "/" . date(U) . ".jpg", "wb");
			fwrite($fp, $GLOBALS['HTTP_RAW_POST_DATA']);
			fclose($fp);
		}
	}
	
	public function records() { 
		$query_rsScore = "SELECT Registration.name, Registration.facebook_id, Score.time, max(total) AS total FROM Registration, Score WHERE Score.registration_id = Registration.registration_id AND total < 10000 GROUP BY Score.registration_id ORDER BY total DESC, Score.time ASC";
		$query_limit_rsScore = sprintf("%s LIMIT %d, %d", $query_rsScore, 0, 13);
		$rsScore = mysql_query($query_limit_rsScore, $this->connection) or die(mysql_error());
		$totalRows_rsScore = mysql_num_rows($rsScore);
		
		$scoreVOs = array();
		$rank = 0;
		while ($row_rsScore = mysql_fetch_assoc($rsScore)) {
			array_push($scoreVOs, new ScoreVO(++$rank, $row_rsScore['name'], $row_rsScore['facebook_id'], $row_rsScore['total']));		
		}
		$this->facade->sendNotification(ApplicationFacade::SCORE_LIST, $scoreVOs);
	}

	public function totalScores() {
		$query_rsScore = "SELECT * FROM Score";
		$rsScore = mysql_query($query_rsScore, $this->connection) or die(mysql_error());
		$totalRows_rsScore = mysql_num_rows($rsScore);
		
		$this->facade->sendNotification(ApplicationFacade::SCORES_TOTAL, $totalRows_rsScore);
	}
	
	public function best() { //best score
		if ((isset($_REQUEST["registration_id"])) && ($_REQUEST["registration_id"] != "")){
			$query_rsScore = sprintf("SELECT Registration.facebook_id, Registration.name, Score.total FROM Registration, Score WHERE Score.registration_id = Registration.registration_id AND Registration.registration_id = %s AND Score.total < 10000 ORDER BY total DESC", SQL::GetSQLValueString($_REQUEST['registration_id'], "int"));
			$query_limit_rsScore = sprintf("%s LIMIT %d, %d", $query_rsScore, 0, 1);
			$rsScore = mysql_query($query_limit_rsScore, $this->connection) or die(mysql_error());
			$row_rsScore = mysql_fetch_assoc($rsScore);
			$totalRows_rsScore = mysql_num_rows($rsScore);
			
			$this->facade->sendNotification(ApplicationFacade::SCORE_BEST, new ScoreVO(null, $row_rsScore['name'], $row_rsScore['facebook_id'], $row_rsScore['total']));
		} else {
			$this->facade->sendNotification(ApplicationFacade::SCORE_BEST, null);
		}
	}
	
	public function rank(){ //rank of a user
		if ((isset($_REQUEST["registration_id"])) && ($_REQUEST["registration_id"] != "")){
			$query_rsScore = "SELECT Registration.registration_id, Registration.name, Registration.facebook_id, Score.total, Score.time FROM Registration, Score WHERE Registration.registration_id = Score.registration_id AND Score.total < 10000 ORDER BY Score.total DESC, Score.time ASC";
			$rsScore = mysql_query($query_rsScore, $this->connection) or die(mysql_error());
			$row_rsScore = mysql_fetch_assoc($rsScore);
			$totalRows_rsScore = mysql_num_rows($rsScore);
			
			$rank = 0;
			if($totalRows_rsScore > 0){
				do {
					$rank++;
					if($row_rsScore['registration_id'] == $_REQUEST['registration_id']){
						break;
					}
				} while ($row_rsScore = mysql_fetch_assoc($rsScore));
				
				$this->facade->sendNotification(ApplicationFacade::SCORE_RANK, new ScoreVO($rank, $row_rsScore['name'], $row_rsScore['facebook_id'], $row_rsScore['total']));
			} else {
				$this->facade->sendNotification(ApplicationFacade::SCORE_RANK, null);
			}
			mysql_free_result($rsScore);
			
		} else {
			$this->facade->sendNotification(ApplicationFacade::SCORE_RANK, null);
		}
	}
	
}
?>