<?php

class DAO_User {
	
	public function login($username, $password) {
		
		$sql = "SELECT * FROM user				
				WHERE username = :username AND password = MD5(:password);";
		$aParam = array(
			array(":username", $username),
			array(":password", $password)
		);
		
		$sth = DB::query($sql, $aParam);
		
		$do_user = $sth->fetch();
		
		return $do_user;
		
	}
	
	public function getUserGroups($userId) {
		
		$aGroup = array();
		
		$sql = "SELECT * FROM user_group
				LEFT JOIN group ON group.group_id = user_group.group_id
				WHERE user_id = :userId;";
		$aParam = array(
			array(":userId", $userId)
		);
		
		$sth = DB::query($sql, $aParam);
		
		while ($do_user_group = $sth->fetch()) {
			LOG::appendLog($do_user_group);
			$aGroup[$do_user_group["group_id"]] = $do_user_group;
			
		}
		
		return $aGroup;
		
	}
	
}