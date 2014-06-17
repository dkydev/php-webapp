<?php

class DB {
	
	public static $dbh;
	private static $debug;
	
	public static function init($aGlobalConfig) {
		
		DB::$debug = PDO::ERRMODE_EXCEPTION;
		
		try {
		
			DB::$dbh = new PDO('mysql:host=localhost;dbname=framework', 'root', '', array(
			    PDO::ATTR_PERSISTENT 	=> 1,
			    PDO::ATTR_ERRMODE 		=> DB::$debug,
			));
		
		} catch (PDOException $e) {
			
			exit($e->getMessage());
			
		}
		
	}
	public static function query($sql, $aParams = null) {
		
		$sth = null;
		
		try {
			
			$sth = DB::$dbh->prepare($sql);
			
			if (!empty($aParams)) {
				foreach ($aParams as $aValue) {
					$sth->bindParam($aValue[0], $aValue[1], empty($aValue[2]) ? null : $aValue[2]);
				}
			}
			
			if (DB::$debug >= 1) {
				
				ob_start();
				
				echo "\n\n[[[\n\n";
				$sth->debugDumpParams();
				echo "\n]]]\n";
				
				LOG::appendLog(ob_get_clean());
				
			}
			
			$sth->execute();
			
		} catch(PDOException $e) {
			
			exit($e->getMessage());
			
		}
		
		return $sth;
		
	}
	
	public static function debug($debugValue) {
		
		DB::$debug = $debugValue;
		DB::$dbh->setAttribute(PDO::ATTR_ERRMODE, $debugValue);
	}
	
}