<?php

class User_Model
{ 
	public function login($username, $password)
	{
		$do_user = DKY_DB::build("user");
		$do_user->where("`username` = :username", "username", $username);
		$do_user->where("`password` = MD5(:password)", "password", $password);
		return $do_user->find(true);
	}
	public function getUserGroupIds($userId)
	{
		$aGroupIds = array();
		$do_user_group = DKY_DB::build("user_group");
		$do_user_group->where("`user_id` = :userId", "userId", $userId);
		$do_user_group->find();
		while ($aUserGroup = $do_user_group->fetch()) {
			$aGroupIds[] = $aUserGroup["group_id"];
		}
		return $aGroupIds;
	}
	public function getUserGroups($userId)
	{
		$aGroups = array();
		$do_user_group = DKY_DB::build("user_group");
		$do_user_group->join("LEFT JOIN `group` ON `group`.`group_id` = `user_group`.`group_id`");
		$do_user_group->where("`user_id` = :userId", array("userId" => $userId));
		$do_user_group->find();
		while ($aUserGroup = $do_user_group->fetch()) {
			$aGroups[$aUserGroup["group_id"]] = $aUserGroup;
		}		
		return $aGroups;
	}
	public function getUser($userId)
	{
		return DKY_DB::get("user", "user_id", $userId);
	}
	public function getGroups($bShort = false)
	{
	    $do_group = DKY_DB::build("group");
	    $do_group->find();
	    $aGroups = array();
	    while ($aGroup = $do_group->fetch()) {
	        if (!$bShort) {
	            $aGroups[$aGroup["group_id"]] = $aGroup;
	        } else {
	            $aGroups[$aGroup["group_id"]] = $aGroup["label"];
	        }
	    }
	    return $aGroups;
	}
	public function getGroup($groupId)
	{
	    return DKY_DB::get("group", "group_id", $groupId);
	}
}

?>