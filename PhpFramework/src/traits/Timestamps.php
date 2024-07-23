<?php

namespace App\traits;

trait Timestamps {
    
    protected $enabled = true;

    public function setCreatedAt(){
        if ($this->enabled && (!isset($this->attributes['created_at'])))
            $this->attributes['created_at'] = date('Y-m-d H:i:s');
    }

    public function setUpdatedAt(){
        if ($this->enabled)
            $this->attributes['updated_at'] = date('Y-m-d H:i:s');
    }

}