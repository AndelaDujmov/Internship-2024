<?php
use App\Connection\Connection;

class Model {

    protected $db;
    protected $table;
    protected $id;
    public $incrementing = true;
    protected $attributes = [];
    protected $with = []; // relacije


    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
    }

    public function save() : void {
        $db = $this->db;
        $attributes = $this->attributes;

        $query = $db->prepare("");


    }

    public function update() : void {

    }

    public static function find(mixed $primaryKey) : object {

    }

    public function toArray() : array {

    }
    
}