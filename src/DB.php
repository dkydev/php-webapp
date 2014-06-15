<?php

class DB {
	
	public static $dbh;
	private static $debug;
	
	public static function init($aGlobalConfig) {
		
		DB::$debug = false;
		
		try {
		
			DB::$dbh = new PDO('mysql:host=localhost;dbname=framework', 'root', '', array(
			    PDO::ATTR_PERSISTENT => true,
			    PDO::ATTR_ERRMODE => true,
			    PDO::ERRMODE_EXCEPTION => true
			));
		
		} catch (PDOException $e) {
			
			exit($e->getMessage());
			
		}
		
	}
	public static function query($sql, $aParam = null) {
		
		$sth = null;
		
		try {
			
			$sth = DB::$dbh->prepare($sql);
			
			foreach ($aParam as $aValue) {
				$sth->bindParam($aValue[0], $aValue[1], empty($aValue[2]) ? null : $aValue[2]);
			}
			
			if (DB::$debug) {
				
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
		
	}
	
}