<?php

namespace App\Connection;

use InvalidArgumentException;
use PDO;
use PDOStatement;
use SensitiveParameter;

class Connection{

    private $dbh;
    private string $dbname;
    private static $instance;

    public function __construct() {
       $this->dbh = new PDO($_ENV['DB_URL'], $_ENV['DB_USER'], $_ENV['DB_PASSWD']);
       $this->dbname = $this->extractDbName($_ENV['DB_URL']);
       $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() : self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getPDO() : PDO {
        return $this->dbh;
    }

    public function fetchAssoc(string $query, array $options = []) : array {
        $pdoStatement = $this->execute($query, $options);
        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll(string $query, array $options = []) : array {
        $pdoStatement = $this->execute($query, $options);
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $tableName, array $assocArray = []) : bool|string {
        /*
        if (isset($assocArray[0]) && is_array($assocArray[0])){
            return $this->groupInsert($tableName, $assocArray);
        }*/
        if($this->singleInsert($tableName, $assocArray))
            return $this->dbh->lastInsertId();
    }

    public function update(string $tableName, array $columnValues = [], array $condition = []) : bool {
        $setPlaceholder = [];
        $setValues = [];
        $wherePlaceholder = [];
        $whereValues = [];

        foreach ($columnValues as $key => $value){
            $setPlaceholder[] = "$key = :set$key";
            $setValues[":set$key"] = $value;
        }

        foreach ($condition as $key => $value){
            $wherePlaceholder[] = "$key = :where$key";
            $whereValues[":where$key"] = $value;
        }

        $set = implode(', ', $setPlaceholder);
        $where = implode(' AND ', $wherePlaceholder);
        
        $query = "UPDATE $this->dbname.$tableName SET $set WHERE $where";
          
        $pdoStatement = $this->dbh->prepare($query);

        foreach ($setValues as $key => $value){
            $pdoStatement->bindValue($key, $value);
        }

        foreach ($whereValues as $key => $value){
            $pdoStatement->bindValue($key, $value);
        }

        return $pdoStatement->execute();
    }

    /*
    private function groupInsert(string $tableName, array $assocArray = []) : bool{
        if (empty($assocArray))
            throw new InvalidArgumentException("Wrong data format for input.");

        $columnArray = array_keys($assocArray);

        foreach ($assocArray as $rowIndex => $row){

        }
    }
    */

    private function singleInsert(string $tableName, array $assocArray = []) : bool {
        if (empty($assocArray))
            throw new InvalidArgumentException("Wrong data format for input.");

        $columnArray = array_keys($assocArray);
        $placeholderArray = [];
        $values = [];
    
        foreach($assocArray as $key => $value){
            $placeholderArray[] = ":$key";
            $values[":$key"] = $value;
        }

        $columns = implode(', ', $columnArray);
        $placeholders = implode(', ', $placeholderArray);

        $query = "INSERT INTO $this->dbname.$tableName ($columns) VALUES ($placeholders)";

        $pdoStatement = $this->dbh->prepare($query);

        foreach($values as $key => $value){
            $pdoStatement->bindValue($key, $value);
        }

        return $pdoStatement->execute();
    }
    
    public function findByID(string $tableName, int|string $modelID, int|string $id) : mixed {
        $query = "SELECT * FROM  $this->dbname.$tableName WHERE {$modelID} = :id";
        $stmt = $this->dbh->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?? null;
    }

    private function execute(string $query, array $params = []) : PDOStatement {
        $pdoStatement = $this->dbh->prepare($query);
        
        if ($params){
            if (strpos($query, '?')){
                for ($i=0; $i< count($params); $i++){
                    $pdoStatement->bindValue($i+1, $params[$i]);
                }
            }else{
                foreach ($params as $key => $value){
                    $pdoStatement->bindValue(":$key", $value);
                }
            }
        }

        $pdoStatement->execute($params);
        return $pdoStatement;
    }

    private function extractDbName(string $dsn): ?string {
        preg_match("/dbname=([^;]*)/", $dsn, $matches);
        print_r($matches); // Debugging line
        return $matches[1] ?? null;
    }   

}