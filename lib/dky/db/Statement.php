<?php

class DKY_DB_Statement
{
    private $_sth;
    private $_aParams;
    private $_query;
    
    private $_table;
    private $_command;
    private $_select;
    private $_join;
    private $_groupBy;
    private $_where;
    private $_orderBy;
    private $_limit;
    
    public function __construct()
    {
    }
    
    public function prepare($sql)
    {
        try {
            $this->_sth = DKY_DB::$dbh->prepare($sql);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function setTable($table)
    {
        $this->_table = $table;
    }
    
    public function select($select)
    {
        if (empty($this->_select)) {
            $this->_select = array();
        }
        $this->_select[] = $select;
    }
    
    public function join($join, $aParams = null)
    {
        if (empty($this->_join)) {
            $this->_join = array();
        }
        $this->_join[] = $join;
        $this->bindParams($aParams);
    }
    
    public function orderBy($orderBy)
    {
        if (empty($this->_orderBy)) {
            $this->_orderBy = array();
        }
        $this->_orderBy[] = $orderBy;
    }
    
    public function groupBy($groupBy, $aParams = null)
    {
        if (empty($this->_groupBy)) {
            $this->_groupBy = array();
        }
        $this->_groupBy[] = $groupBy;
        $this->bindParams($aParams);
    }
    
    /**
     * Add a where clause to the query statement.
     * Specify parameters as an array or a single parameter key and value.
     * 
     * @param string $where            
     * @param array|string $aParams            
     * @param string $value
     */
    public function where($where, $aParams = null, $value = null)
    {
        if (empty($this->_where)) {
            $this->_where = array();
        }
        $this->_where[] = " (" . $where . ") ";
        if (!empty($aParams)) {
            if (is_array($aParams)) {
                $this->bindParams($aParams);
            } else if (!empty($value)) {
                $this->bind($aParams, $value);
            }
        }
    
    }
    
    public function limit($limit, $offset = null, $aParams = null)
    {
        if (!empty($offset)) {
            $this->_limit = $offset . " " . $limit;
        } else {
            $this->_limit = $limit;
        }
        $this->bindParams($aParams);
    }
    
    /**
     * Bind an array of parameters to the query statement in the form of
     * <code>array("key" => {value})</code>
     * or
     * <code>array("key" => array("value" => {value}, "type" => {type}))</code>
     *
     * @param array $aParams            
     */
    public function bindParams($aParams)
    {
        if (!empty($aParams) && is_array($aParams)) {
            foreach ($aParams as $parameter => $value) {
                if (is_array($value)) {
                    $this->bind($parameter, $value["value"], $value["type"]);
                } else {
                    $this->bind($parameter, $value);
                }
            }
        }
    }
    
    public function bind($parameter, $value, $type = null)
    {
        if (empty($this->_aParams)) {
            $this->_aParams = array();
        }
        if (is_null($type)) {
            switch (true) {
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->_aParams[$parameter] = array(
                "value" => $value,
                "type" => $type 
        );
    }
    
    public function getSelectQuery()
    {
        if (empty($this->_select)) {
            $selectCols = "*";
        } else {
            $selectCols = implode(",", $this->_select);
        }
        $sql = "SELECT " . $selectCols . " FROM `" . $this->_table . "`";
        if (!empty($this->_where)) {
            $sql .= " WHERE " . implode(" AND ", $this->_where);
        }
        if (!empty($this->_groupBy)) {
            $sql .= " GROUP BY " . implode(",", $this->_groupBy);
        }
        if (!empty($this->_orderBy)) {
            $sql .= " ORDER BY " . implode(",", $this->_orderBy);
        }
        if (!empty($this->_limit)) {
            $sql .= " LIMIT " . implode(" AND ", $this->_limit);
        }
        return $sql;
    }
    
    public function find($bFetchOne = false)
    {
        $this->_query = $this->getSelectQuery();
        $this->prepare($this->_query);
        if ($bFetchOne) {
            $this->execute();
            return $this->fetch();
        } else {
            return $this->execute();
        }
    }
    
    public function update($aValues)
    {
        $aUpdate = array();
        foreach ($aValues as $key => $value) {
            $aUpdate[] = "`" . $key . "` = :" . $key;
        }
        $this->_query = "UPDATE `" . $this->_table . "` SET " . implode(",", $aUpdate);
        if (!empty($this->_where)) {
            $this->_query .= " WHERE " . implode(" AND ", $this->_where);
        }
        $this->_query .= ";";
        $this->bindParams($aValues);
        $this->prepare($this->_query);
        return $this->execute();
    }
    
    public function insert($aValues)
    {
        $this->_query = "INSERT INTO `" . $this->_table . "` (`" . implode("`,`", array_keys($aValues)) . "`)
             VALUES (:" . implode(",:", array_keys($aValues)) . ");";
        $this->bindParams($aValues);
        $this->prepare($this->_query);
        $this->execute();
        return DKY_DB::getLastInsertId();
    }
    
    public function delete()
    {
        $this->_query = "DELETE FROM `" . $this->_table . "`";
        if (!empty($this->_where)) {
            $this->_query .= " WHERE " . implode(" AND ", $this->_where);
        }
        $this->prepare($this->_query);
        return $this->execute();
    }
    
    public function execute()
    {
        try {
            if (!empty($this->_aParams) && is_array($this->_aParams)) {
                foreach ($this->_aParams as $paramName => $aParam) {
                    $this->_sth->bindValue(":" . $paramName, $aParam["value"], $aParam["type"]);
                }
            }
            return $this->_sth->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function fetch()
    {
        try {
            return $this->_sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function fetchAll()
    {
        try {
            return $this->_sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function getRowCount()
    {
        try {
            return $this->_sth->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public function getStatementHandler()
    {
        return $this->_sth;
    }
    
    public function getStatementParams()
    {
        return $this->_aParams;
    }
}

?>