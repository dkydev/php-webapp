<?php

class DB {
    
    private static $dbh;
    
    public static function init()
    {
        $dbHost     = Config::get("db_host");
        $dbName     = Config::get("db_name");
        $dbUsername = Config::get("db_username");
        $dbPassword = Config::get("db_password");
        try {
            DB::$dbh = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName, $dbUsername, $dbPassword, array(
                PDO::ATTR_PERSISTENT => 1,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ));
        } catch (PDOException $e) {            
            exit($e->getMessage());
        }        
    }
    public static function query($sql)
    {        
        return new DB($sql);
    }
    public static function get($table, $table_key, $id)
    {
        $sth = DB::query("SELECT * FROM `" . $table . "` WHERE `" . $table_key . "` = :" . $table_key . ";");
        $sth->bind($table_key, $id);
        $sth->execute();
        return $sth->fetch();
    }
    public static function insert($table, $aValues)
    {
        $sth = DB::query(
            "INSERT INTO `" . $table . "` (`" . implode("`,`", array_keys($aValues)) . "`) 
             VALUES (:" . implode(",:", array_keys($aValues)) . ");"
        );
        foreach ($aValues as $key => $value) {
            $sth->bind($key, $value);
        }
        $sth->execute();
        return DB::getLastInsertId();
    }
    public static function update($table, $aValues, $table_key, $id)
    {
        $aUpdate = array();
        foreach ($aValues as $key => $value) {
            $aUpdate[] = "`" . $key . "` = :" . $key;
        }
        $sth = DB::query("UPDATE `" . $table . "` SET " . implode(", ", $aUpdate) . " WHERE `" . $table_key . "` = :" . $table_key . ";");
        $sth->bind($table_key, $id);
        foreach ($aValues as $key => $value) {
            $sth->bind($key, $value);
        }
        return $sth->execute();        
    }
    public static function beginTransaction()
    {
        try {
            return DB::$dbh->beginTransaction();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function commit()
    {
        try {
            return DB::$dbh->commit();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function getLastInsertId()
    {
        try {
            return DB::$dbh->lastInsertId();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public static function getColumns($table)
    {
        $sth = DB::query("DESCRIBE `" . $table . "`;");
        $sth->execute();
        return $sth->fetchAll();
    }
    public static function debug($debugValue)
    {
        DB::$dbh->setAttribute(PDO::ATTR_ERRMODE, $debugValue);
    }
    
    /*****************************************************************************/
    
    private $_sth;
    private $_aParams;
    
    public function __construct($sql)
    {
        try {
            $this->_sth = DB::$dbh->prepare($sql);
            $this->_aParams = array();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function bind($parameter, $value, $type = null)
    {
        if (empty($this->_sth)) {
            return;
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
            "type" => $type,
        );        
    }
    public function execute()
    {
        if (empty($this->_sth)) {
            return;
        }
        try {
            foreach ($this->_aParams as $paramName => $aParam) {
                $this->_sth->bindValue(":".$paramName, $aParam["value"], $aParam["type"]);
            }
            return $this->_sth->execute();
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function fetch()
    {
        if (empty($this->_sth)) {
            return;
        }
        try {
            return $this->_sth->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function fetchAll()
    {
        if (empty($this->_sth)) {
            return;
        }
        try {
            return $this->_sth->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function getRowCount()
    {
        if (empty($this->_sth)) {
            return;
        }
        try {
            return $this->_sth->rowCount();
        } catch(PDOException $e) {
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

