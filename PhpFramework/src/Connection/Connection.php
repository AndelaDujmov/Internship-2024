<?php

class Connection{

    private $pdo;

    public function __construct(string $dsn, string $username, #[SensitiveParameter] ?string $password = null) {
        $this->pdo = new PDO($dsn, $username, $password);
    }

    public function fetchAssoc(string $query, array $options = []) : array {
        $pdoStatement = $this->pdo->prepare($query);
        $pdoStatement->execute();
        return $pdoStatement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAssocAll(string $query, array $options = []) : array {
        $this->pdo->prepare($query);
    }

}