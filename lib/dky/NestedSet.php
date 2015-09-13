<?php

class DKY_NestedSet
{
    private $_table;
    private $_table_key;
    
    public function __construct($table, $table_key)
    {
        $this->_table = $table;
        $this->_table_key = $table_key;
    }
    
    private function getNextOrder($level)
    {
        $sth = DKY_DB::query("SELECT COUNT(*) as `count` FROM `" . $this->_aConfig["table"] . "` 
            WHERE `" . $this->_aConfig["level"] . "` = :level;");
        $sth->bind("level", $level);
        $sth->execute();
        $aRootCount = $sth->fetch();
        return $aRootCount["count"] + 1;
    }
    
    public function insertNode($aNode)
    {
        if (empty($aNode["parent_id"])) {
            return $this->insertRootNode($aNode);
        } else {
            return $this->insertChildNode($aNode);
        }
    }
    
    public function insertChildNode($aNode)
    {
        DKY_DB::beginTransaction();
        
        $aParentNode = DKY_DB::get($this->_table, $this->_table_key, $aNode["parent_id"]);
        if (empty($aParentNode))
            return false;
        
        if (empty($aNode["left_id"])) {
            $leftId = $this->_getNextLeftId($aNode["parent_id"]);
        } else {
            $leftId = $aNode["left_id"];
            $this->_shiftNodesRight(2, $leftId);
        }
        
        $aNode["root_id"] = $aParentNode["root_id"] + 1;
        $aNode["parent_id"] = $aNode["parent_id"];
        $aNode["level_id"] = $aParentNode["level_id"] + 1;
        $aNode["left_id"] = $leftId;
        $aNode["right_id"] = $leftId + 1;
        
        $nodeId = DKY_DB::insert($this->_table, $aNode);
        
        DKY_DB::commit();
        return $nodeId;
    }
    
    public function insertRootNode($aNode)
    {
        DKY_DB::beginTransaction();
        
        if (empty($aNode["left_id"])) {
            $leftId = $this->_getNextLeftId(null);
        } else {
            $leftId = $aNode["left_id"];
            $this->_shiftNodesRight(2, $leftId);
        }
        
        $aNode["root_id"] = DKY_DB::getNextInsertId($this->_table);
        $aNode["parent_id"] = null;
        $aNode["level_id"] = 1;
        $aNode["left_id"] = $leftId;
        $aNode["right_id"] = $leftId + 1;
        
        $nodeId = DKY_DB::insert($this->_table, $aNode);
        
        DKY_DB::commit();
        return $nodeId;
    }
    
    public function getNodeById($nodeId)
    {
        return DKY_DB::get($this->_table, $this->_table_key, $nodeId);
    }
    
    private function _shiftNodesRight($shiftCount, $startId)
    {
        $do_set = DKY_DB::query("UPDATE " . $this->_table . " SET `left_id` = `left_id` + :shiftCount WHERE `left_id` >= :startId;");
        $do_set->bind("shiftCount", $shiftCount);
        $do_set->bind("startId", $startId);
        $do_set->execute();
        $do_set = DKY_DB::query("UPDATE " . $this->_table . "SET `right_id` = `right_id` + :shiftCount WHERE `right_id` >= :startId;");
        $do_set->bind("shiftCount", $shiftCount);
        $do_set->bind("startId", $startId);
        $do_set->execute();
    }
    
    private function _shiftNodesLeft($shiftCount, $startId)
    {
        $do_set = DKY_DB::query("UPDATE " . $this->_table . " SET `left_id` = `left_id` - :shiftCount WHERE `left_id` >= :startId;");
        $do_set->bind("shiftCount", $shiftCount);
        $do_set->bind("startId", $startId);
        $do_set->execute();
        $do_set = DKY_DB::query("UPDATE " . $this->_table . "SET `right_id` = `right_id` - :shiftCount WHERE `right_id` >= :startId;");
        $do_set->bind("shiftCount", $shiftCount);
        $do_set->bind("startId", $startId);
        $do_set->execute();
    }
    
    private function _getNextLeftId($parentId = null)
    {
        if (!empty($parentId)) {
            $sth = DKY_DB::query("SELECT MAX(`right_id`) as 'right_id' FROM `" . $this->_table . "` WHERE `parent_id` = :parentId;");
            $sth->bind("parentId", $parentId);
        } else {
            $sth = DKY_DB::query("SELECT MAX(`right_id`) as 'right_id' FROM `" . $this->_table . "` WHERE `parent_id` IS NULL;");
        }
        $sth->execute();
        $result = $sth->fetch();
        return $result["right_id"] + 1;
    }
    
    public function updateNode($aNode)
    {
        unset($aNode["parent_id"]);
        DKY_DB::beginTransaction();
        $result = DKY_DB::update($this->_table, $aNode, $this->_table_key, $aNode[$this->_table_key]);
        return DKY_DB::commit();
    }
    
    public function moveBranch($nodeId, $parentId, $leftId = null)
    {
    
    }
    
    public function deleteBranch($nodeId)
    {
        DKY_DB::beginTransaction();
        
        $aNode = $this->getNodeById($nodeId);
        
        $do_set = DKY_DB::query("DELETE FROM `" . $this->_table . "` WHERE `left_id` >= :leftId AND `right_id` <= :rightId");
        $do_set->bind("leftId", $aNode["left_id"]);
        $do_set->bind("rightId", $aNode["right_id"]);
        $do_set = $sth->execute();
        
        $this->_shiftNodesLeft($aNode["right_id"] - $aNode["left_id"] + 1, $aNode["left_id"]);
        
        return DKY_DB::commit();
    }
}