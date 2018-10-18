<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';
    public $timestamps = false;

    public function scopeGetActiveUnit($query)
    {
        return $query->where('is_active', '=', 1)->get();
    }

    public static function checkUnitName($unitname)
    {
        $unitname = unit::where(['is_active' => 1, 'unit' => $unitname])->first();
        if (is_null($unitname)) return true;
        else return false;
    }
    public
    function scopegetUnitDropdown()
    {
        $Mcat = Unit::where('is_active', '1')->get(['id', 'unit']);
        $arr[0] = "SELECT";
        foreach ($Mcat as $Mcat) {
            $arr[$Mcat->id] = $Mcat->unit;
        }
        return $arr;
    }
}
