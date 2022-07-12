<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientSched extends Model
{
    protected $table = 'patient_scheds';
    protected $guarded = array();

    public function patient() {
        return $this->hasOne(User::class, 'id', 'patient_id');
    }
    public function schedule() {
        return $this->hasOne(DoctorSched::class, 'id', 'schedule_id');
    }
}
