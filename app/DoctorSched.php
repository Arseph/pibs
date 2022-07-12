<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorSched extends Model
{
    protected $table = 'doctor_scheds';
    protected $guarded = array();
    
    public function doctor() {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
