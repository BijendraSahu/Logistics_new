<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagerRequest extends Model
{
    protected $table = 'manager_request';
    public $timestamps = false;

    public function material()
    {
        return $this->belongsTo('App\Material', 'material_id');
    }

    public function material_type()
    {
        return $this->belongsTo('App\MaterialType', 'material_type_id');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit', 'unit_id');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle', 'vehicle_id');
    }

    public function supervisor()
    {
        return $this->belongsTo('App\UserMaster', 'created_by');
    }

}
