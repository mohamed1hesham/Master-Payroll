<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstancesPeriod extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function instanceData()
    {
        return $this->belongsTo(CiInstances::class, 'instance_id', 'id');
    }
    public function payrollData()
    {
        return $this->belongsTo(InstancesPayroll::class, 'payroll_id', 'id');
    }
}
