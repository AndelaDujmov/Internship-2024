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