<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstancesPayroll extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function instanceData()
    {
        return $this->belongsTo(CiInstances::class, 'instance_id', 'id');
    }
}
