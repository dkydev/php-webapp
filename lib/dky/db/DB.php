<?php

require_once 'Statement.php';

class DKY_DB
{
    public static $dbh;
    
    /**
     * Initialize the database handler.
     *
     * @param array $aParams
     *            An array of PDO connection parameters: 'host', 'database', 'username', 'password'.
     */
    public static function initialize($aParams)
    {
        $dbHost = $aParams["host"];
        $dbName = $aParams["database"];
        $dbUsername = $aParams["username"];
        $dbPassword = $aParams["password"];
        try {
            DKY_DB::$dbh = new PDO("mysql:host=" . $dbHost . ";dbname=" . $dbName, $dbUsername, $dbPassword, array(
                    PDO::ATTR_PERSISTENT => 1,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
            ));
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    /**
     * Get a statement handler to build a query with the specified table.
     *
     * @param string $table            
     * @return DKY_DB_Statement
     */
    public static function build($table)
    {
        $sth = new DKY_DB_Statement();
        $sth->setTable($table);
        return $sth;
    }
    
    /**
     * Gets a statement handler with a query string.
     *
     * @param string $sql
     *            The raw SQL query string.
     * @param array $aParams
     *            Query parameters to bind to the statement.
     * @return DKY_DB_Statement A wrapper for the PDO statement handler.
     */
    public static function query($sql, $aParams = null)
    {
        $sth = new DKY_DB_Statement();
        $sth->bindParams($aParams);
        $sth->prepare($sql);
        return $sth;
    }
    
    /**
     * Shorthand fetch single row using specified column and value.
     *
     * @param string $tableName
     *            The name of the table to select from.
     * @param string $column
     *            (optional) Column name to query on.
     * @param integer $value
     *            (optional) The value of the column.
     * @return An associative array of the table row.
     */
    public static function get($tableName, $column = null, $value = null)
    {
        $sth = DKY_DB::build($tableName);
        if (!empty($column) && !empty($value)) {
            $sth->where("`" . $column . "` = :" . $column . "", $column, $value);
        }
        return $sth->find(true);
    }
    /**
     * Insert a row into the specified table.
     *
     * @param string $tableName
     *            The name of the table to insert into.
     * @param array $aValues
     *            An associative array of columns to values to insert.
     * @return Returns the last insert ID on success, false on fail.
     */
    public static function insert($tableName, $aValues)
    {
        $sth = DKY_DB::query("INSERT INTO `" . $tableName . "` (`" . implode("`,`", array_keys($aValues)) . "`) 
             VALUES (:" . implode(",:", array_keys($aValues)) . ");");
        foreach ($aValues as $key => $value) {
            $sth->bind($key, $value);
        }
        if ($sth->execute()) {
            return DKY_DB::getLastInsertId();
        } else {
            return false;
        }
    }
    
    /**
     * Update a row into the specified table using the primary key.
     *
     * @param string $tableName
     *            The name of the table to update.
     * @param array $aValues
     *            An associative array of columns to values to update.
     * @param string $tableKey
     *            The column name of the primary key.
     * @param string $keyId
     *            The primary key value.
     * @return Returns query execution result.
     */
    public static function update($tableName, $aValues, $tableKey, $keyId)
    {
        $aUpdate = array();
        foreach ($aValues as $key => $value) {
            $aUpdate[] = "`" . $key . "` = :" . $key;
        }
        $sth = DKY_DB::query("UPDATE `" . $tableName . "` SET " . implode(", ", $aUpdate) . " WHERE `" . $tableKey . "` = :" . $tableKey . ";");
        $sth->bind($tableKey, $keyId);
        foreach ($aValues as $key => $value) {
            $sth->bind($key, $value);
        }
        return $sth->execute();
    }
    
    public static function beginTransaction()
    {
        try {
            return DKY_DB::$dbh->beginTransaction();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public static function commit()
    {
        try {
            return DKY_DB::$dbh->commit();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public static function getNextInsertId($table)
    {
        try {
            $sth = DKY_DB::query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = '$table'");
            $sth->execute();
            $result = $sth->fetch();
            return $result["AUTO_INCREMENT"];
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public static function getLastInsertId()
    {
        try {
            return DKY_DB::$dbh->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    public static function getColumns($table)
    {
        $sth = DKY_DB::query("DESCRIBE `" . $table . "`;");
        $sth->execute();
        return $sth->fetchAll();
    }
    
    public static function debug($debugValue)
    {
        DKY_DB::$dbh->setAttribute(PDO::ATTR_ERRMODE, $debugValue);
    }
}

?>

