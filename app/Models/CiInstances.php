<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CiInstances extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }
    public function payroll()
    {
        return $this->hasMany(InstancesElements::class, 'instance_id', 'id');
    }
}
