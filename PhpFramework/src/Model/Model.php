<?php

namespace App\Model;
use App\Connection\Connection;

class Model {

    protected $db;
    protected $table;
    protected $id = 'id';
    public array $attributes = [];

    public function __construct(?array $attributes = []) {
        $this->attributes = $attributes;
        $this->db = Connection::getInstance();
    }

    public function save() : void {
        if (isset($this->attributes[$this->id])) {
            $this->update();
        }else{
            $id = $this->db->insert($this->table, $this->attributes);
            $attributes[$this->id] = $id;
        }
    }

    public function update() : void {
        $pkValue = $this->attributes[$this->id];
        unset($this->attributes[$this->id]);
        $this->db->update($this->table, $this->attributes, [$this->id => $pkValue]);
    }

    public static function find(int|string $primaryKey) : object|null {
        $instance = new static();
  
        $result = $instance->db->findByID($instance->table, $instance->id, $primaryKey);
        
        if ($result) {
            foreach ($result as $key => $value) {
                $instance->attributes[$key] = $value;
            }
            return $instance;
        }

        return null;
    }

    public function toArray() : array {
        return $this->attributes;  
        
    }

    public function __set($name, $value) : void {
        $this->attributes[$name] = $value;
    }

    public function __get($name) : mixed {
        return $this->attributes[$name] ?? null;
    }
    
}