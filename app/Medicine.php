<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $table = 'medicines';
    protected $guarded = array();
    
    public function doctor() {
        return $this->hasMany(User::class, 'id', 'doctor_id');
    }
}
