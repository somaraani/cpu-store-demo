<?php

//Singleton database connector
class DatabaseConnector
{
    private static $instance = null;

    private $dbConnection = null;
    
    private function __construct()
    {
        $server   = 'tcp:sql-server,1433';
        $connectionOptions = array(
            "Database" => "db",
            "Uid" => "sa", "PWD" => "StrongP@ssword!"
        );

        # Connect
        $this->dbConnection =  sqlsrv_connect($server, $connectionOptions);
        if ($this->dbConnection == false)
            die(var_dump(sqlsrv_errors()));
    }

    // Returns singleton instance of db connector
    public static function getInstance()
    {
      if (self::$instance == null){
        self::$instance = new DatabaseConnector();
      }
      return self::$instance;
    }

    // Executes sql statement and returns output as JSON
    public function execute($sql, $params = array(), $array = true)
    {
        $getRows = sqlsrv_query($this->dbConnection, $sql, $params);
        if ($getRows == FALSE)
            die(var_dump(sqlsrv_errors()));

        while ($row = sqlsrv_fetch_array($getRows, SQLSRV_FETCH_ASSOC)) {
            $res[] = $row;
        }

        sqlsrv_free_stmt($getRows);

        if(is_null($res)) {
            return null;
        }

        if(!$array && count($res) >= 1) {
            return json_encode(array_pop($res));
        }

        return json_encode($res);
    }

    // Inserts record, and returns id 
    public function insert($sql, $params)
    {
        $sql = $sql . "; SELECT SCOPE_IDENTITY()";
        $resource = sqlsrv_query($this->dbConnection, $sql, $params);
        sqlsrv_next_result($resource);
        sqlsrv_fetch($resource);
        return sqlsrv_get_field($resource, 0);
    }
    
}
