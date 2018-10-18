<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PetrolOrder extends Model
{
    protected $table = 'petrol_order';
    public $timestamps = false;

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
        return $this->belongsTo('App\UserMaster', 'order_by');
    }
}
