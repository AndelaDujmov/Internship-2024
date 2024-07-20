<?php

class Connection{

    private $dbh;
    private static $instance;

    public function __construct(string $dsn, string $username, #[SensitiveParameter] ?string $password = null) {
       $this->dbh = new PDO($dsn, $username, $password);
       $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(string $dsn, string $username, #[SensitiveParameter] ?string $password = null) : self {
        if (self::$instance === null) {
            self::$instance = new self($dsn, $username, $password);
        }
        return self::$instance;
    }

    public function fetchAssoc(string $query, array $options = []) : array {
        $pdoStatement = $this->execute($query, $options);
        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll(string $query, array $options = []) : array {
        $pdoStatement = $this->execute($query, $options);
        return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $tableName, array $assocArray = []) : bool {
        /*
        if (isset($assocArray[0]) && is_array($assocArray[0])){
            return $this->groupInsert($tableName, $assocArray);
        }*/
        return $this->singleInsert($tableName, $assocArray);
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

        $query = 'UPDATE $tableName SET $set WHERE $where';

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

        $query = 'INSERT INTO $tableName ($columns) VALUES ($placeholders)';

        $pdoStatement = $this->dbh->prepare($query);

        foreach($values as $key => $value){
            $pdoStatement->bindValue($key, $value);
        }

        return $pdoStatement->execute();
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

}