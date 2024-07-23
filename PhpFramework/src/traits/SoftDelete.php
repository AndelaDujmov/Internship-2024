<?php

namespace App\traits;

trait SoftDelete {

    public function softDelete() : void {
        $this->attributes['deleted_at'] = date('Y-m-d H:i:s');
        $this->update();
    }

    public function delete(){
        echo $this->id;
        $pkValue = $this->attributes[$this->id];
        $this->db->delete($this->table, [$this->id => $pkValue]);
    }

}