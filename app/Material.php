<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'material';
    public $timestamps = false;

    public function scopeGetActiveMaterial($query)
    {
        return $query->where('is_active', '=', 1)->get();
    }

    public static function checkMaterialName($unitname)
    {
        $unitname = Material::where(['is_active' => 1, 'name' => $unitname])->first();
        if (is_null($unitname)) return true;
        else return false;
    }

    public
    function location()
    {
        return $this->belongsTo('App\LocationMaster','location_id');
    }

    public
    function scopegetMaterialDropdown()
    {
        $Mcat = Material::where('is_active', '1')->get(['id', 'name']);
        $arr[0] = "SELECT";
        foreach ($Mcat as $Mcat) {
            $arr[$Mcat->id] = $Mcat->name;
        }
        return $arr;
    }


}
