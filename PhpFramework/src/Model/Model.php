<?php
use App\Connection\Connection;

class Model {

    private $db;
    public $table;
    public $attributes = [];
    public $id;

    public function __construct(Connection $connection) {
        $this->db = $connection;
    }

    public function save() : void {

    }

    public function update() : void {

    }

    public static function find(mixed $primaryKey) : object {

    }

    public function toArray() : array {

    }
    
}