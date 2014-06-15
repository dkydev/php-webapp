<?php

class DAO_User {
	
	public function login($username, $password) {
		
		$sql = "SELECT * FROM `user`			
				WHERE `username` = :username AND `password` = MD5(:password);";
		$aParam = array(
			array(":username", $username, PDO::PARAM_STR),
			array(":password", $password, PDO::PARAM_STR)
		);
		
		$sth = DB::query($sql, $aParam);
		
		$do_user = $sth->fetch(PDO::FETCH_ASSOC);
		
		return $do_user;
		
	}
	
	public function getUserGroups($userId) {
		
		$aGroup = array();
		
		$sql = "SELECT * FROM `user_group`
				LEFT JOIN `group` ON `group`.`group_id` = `user_group`.`group_id`
				WHERE `user_id` = :userId;";
		$aParam = array(
			array(":userId", $userId, PDO::PARAM_INT)
		);
		
		$sth = DB::query($sql, $aParam);
		
		while ($do_user_group = $sth->fetch(PDO::FETCH_ASSOC)) {
			
			$aGroup[$do_user_group["group_id"]] = $do_user_group;
			
		}
		
		return $aGroup;
		
	}
	
}