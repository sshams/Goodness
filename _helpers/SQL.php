<?php

class SQL {
	
	public static function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
		
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}
	
		$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
		
		switch ($theType) {
			case "text":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "long":
			case "int":
				$theValue = ($theValue != "") ? intval($theValue) : "NULL";
				break;
			case "double":
				$theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
				break;
			case "date":
				$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
				break;
			case "defined":
				$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
				break;
		}
		return $theValue;
	}
	
	public static function display_recordset($recordset){
		$n = 0;
		mysql_data_seek($recordset, 0);
		echo "<table border='1' cellpadding='5' cellspacing='0'>";
			echo "<tr><th>S. No.</th>";
				$row = mysql_fetch_assoc($recordset);
				foreach($row as $name => $value){
					echo "<th>" . $name . "</th>";
				}
			echo "</tr>";
		
			mysql_data_seek($recordset, 0);
		
			while($row = mysql_fetch_assoc($recordset)){
				echo "<td>" . ++$n . "</td>";
				foreach($row as $name => $value) {
					echo "<td>" . $value . "</td>";
				}
				echo "</tr>";
			}
		echo "</table>";
		echo mysql_num_rows($recordset) . " row(s)";
		mysql_data_seek($recordset, 1);
	}
	
	public static function html_encode($string) {
		return htmlentities($string, ENT_QUOTES, 'UTF-8') ;
	}
	
}
?>