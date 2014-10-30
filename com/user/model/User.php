<?php

class User_Model
{ 
	public function login($username, $password)
	{
		$sth = DB::query("SELECT * FROM `user` WHERE `username` = :username AND `password` = MD5(:password);");
		$sth->bind("username", $username);
		$sth->bind("password", $password);
		$sth->execute();
		$aUser = $sth->fetch();
		
		return $aUser;
	}
	public function getUserGroupIds($user_id)
	{
		$aGroupIds = array();
		$sth = DB::query("SELECT * FROM `user_group` WHERE `user_id` = :user_id;");
		$sth->bind("user_id", $user_id);
		$sth->execute();
		while ($aUserGroup = $sth->fetch()) {
			$aGroupIds[] = $aUserGroup["group_id"];
		}		
		return $aGroupIds;
	}
	public function getUserGroups($user_id)
	{
		$aGroups = array();
		$sql = "SELECT * FROM `user_group`
				LEFT JOIN `group` ON `group`.`group_id` = `user_group`.`group_id`
				WHERE `user_id` = :user_id;";
		$sth = DB::query($sql);
		$sth->bind("user_id", $user_id);
		$sth->execute();
		while ($aUserGroup = $sth->fetch(PDO::FETCH_ASSOC)) {
			$aGroups[$aUserGroup["group_id"]] = $aUserGroup;
		}
		
		return $aGroups;
	}
	public function getUser($user_id)
	{
		return DB::get("user", "user_id", $user_id);
	}
	public function getGroups()
	{
	    $sth = DB::query("SELECT * from `group`;");
	    $sth->execute();
	    $aGroups = array();
	    while ($aGroup = $sth->fetch()) {
	        $aGroups[$aGroup["group_id"]] = $aGroup;
	    }
	    return $aGroups;
	}
	public function getGroup($group_id)
	{
	    return DB::get("group", "group_id", $group_id);
	}
}

?>