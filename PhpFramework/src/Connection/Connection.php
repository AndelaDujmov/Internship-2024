<?php

class Connection{

    private $pdo;

    public function __construct($dsn, $username, $password) {
        $this->pdo = new PDO($dsn, $username, $password);
    }

    public function fetchAssoc(string $query, array $options = []) : array {
        $this->pdo->prepare($query);
    }

    public function fetchAssocAll(string $query, array $options = []) : array {
        $this->pdo->prepare($query);
    }
}