<?php

namespace Core\Database\DBConnection;

use PDO;

class DBConnection
{
    private static $dbConnectionInstance = null;

    private function __construct(){}

    public static function getDBConnectionInstance()
    {
        if(self::$dbConnectionInstance == null){
            $BDConnectionInstance = new DBConnection();
            self::$dbConnectionInstance = $BDConnectionInstance->dbConnection();
            echo "connected successfully";
        }
        return self::$dbConnectionInstance;
    }

    public function dbConnection()
    {
        $servername = DBHOST;
        $username = DBUSERNAME;
        $password = DBPASSWORD;
        $dbname = DBNAME;
        try{
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch (\PDOException $e){
            echo $e->getMessage();
            return false;
        }
    }

    public static function newInsertedId()
    {
        return self::getDBConnectionInstance()->lastInsertId();
    }
}