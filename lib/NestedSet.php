<?php

class NestedSet {
    
    private $_table;
    private $_table_key;
    
    public function __construct($table, $table_key)
    {
        $this->_table = $table;
        $this->_table_key = $table_key;
    }
    private function getNextOrder($level)
    {
        $sth = DB::query(
            "SELECT COUNT(*) as `count` FROM `" . $this->_aConfig["table"] . "` 
            WHERE `" . $this->_aConfig["level"] . "` = :level;"
        );
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
            
        }                
    }    
    public function insertRootNode($aNode)
    {
        DB::beginTransaction();
        $nodeId = DB::insert($this->_table, $aNode);
        $aNode["root_id"]   = $nodeId;
        $aNode["parent_id"] = null;
        $aNode["left_id"]   = $nodeId;
        $aNode["right_id"]  = $nodeId;
        $aNode["level"]     = 1;
        $aNode["order"]     = $this->getNextNodeId(1);
        DB::update($this->_table, $aNode, $this->_table_key, $nodeId);        
        return DB::commit();
        
        /*
        $aNode["root_id"]
        
        
        
        
        
        
        
        $DBO = new DBO($this->aConfig["table"]);
        $DBO->setValues($aNode);
        return $DBO->insert();
        
        $sql = "INSERT INTO `" . $this->aConfig["table"] . "`
                VALUES (`block_group`.`group_id` IN (:aGroupId);";
        $sth = DB::query("INSERT INTO ");
        $sth->bind("page_id", $pageId);
        $sth->bind("aGroupId", $_SESSION["aGroupId"]);
        $sth->execute();
        */
    }
    public function updateNode($aNode)
    {
        DB::beginTransaction();
        $result = DB::update("menu_item", $aNode, "menu_item_id");
        return DB::commit();
    }
    public function deleteNode($nodeId)
    {
        DB::beginTransaction();
        $sth = DB::query("DELETE FROM `" . $this->_aConfig["table"] . "` WHERE `" . $this->_aConfig["node_id"] . "` = :" . $this->_aConfig["node_id"] . ";");
        $sth->bind($this->_aConfig["node_id"], $nodeId);
        $result = $sth->execute();
        return DB::commit();
    }
}