<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehicle';
    public $timestamps = false;

    public function scopeGetActiveVehicle($query)
    {
        return $query->where('is_active', '=', 1)->get();
    }

    public static function checkVehicleName($unitname)
    {
        $unitname = Vehicle::where(['is_active' => 1, 'vehicle_no' => $unitname])->first();
        if (is_null($unitname)) return true;
        else return false;
    }

    public static function echeckVehicleName($unitname, $id)
    {
        $unitname = Vehicle::where(['is_active' => 1, 'vehicle_no' => $unitname])->where('id', '!=', $id)->first();
        if (is_null($unitname)) return true;
        else return false;
    }

    public
    function scopegetVehicleDropdown()
    {
        $Mcat = Vehicle::where('is_active', '1')->get(['id', 'vehicle_no']);
        $arr[0] = "SELECT";
        foreach ($Mcat as $Mcat) {
            $arr[$Mcat->id] = $Mcat->vehicle_no;
        }
        return $arr;
    }
}
