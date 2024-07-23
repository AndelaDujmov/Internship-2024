<?php

namespace App\Model;
use App\Connection\Connection;
use App\traits\SoftDelete;
use App\traits\Timestamps;

class Model {

    use Timestamps, SoftDelete;
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
            if ($this->enabled && !isset($this->attributes["created_at"]))
                $this->setCreatedAt();
            $id = $this->db->insert($this->table, $this->attributes);
            $attributes[$this->id] = $id;
        }
    }

    public function update() : void {
        if ($this->enabled)
            $this->setUpdatedAt();
        $pkValue = $this->attributes[$this->id];
        $id = $this->db->update($this->table, $this->attributes, [$this->id => $pkValue]);
        $attributes[$this->id] = $id;
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