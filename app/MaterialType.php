<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialType extends Model
{
    protected $table = 'material_type';
    public $timestamps = false;

    public function scopeGetActiveMT($query)
    {
        return $query->where('is_active', '=', 1)->get();
    }

    public static function checkMT($unitname)
    {
        $unitname = MaterialType::where(['is_active' => 1, 'type' => $unitname])->first();
        if (is_null($unitname)) return true;
        else return false;
    }

    public static function echeckMT($unitname, $id)
    {
        $unitname = MaterialType::where(['is_active' => 1, 'type' => $unitname])->where('id', '!=', $id)->first();
        if (is_null($unitname)) return true;
        else return false;
    }
    public
    function scopegetMaterialTypeDropdown()
    {
        $Mcat = MaterialType::where('is_active', '1')->get(['id', 'type']);
        $arr[0] = "SELECT";
        foreach ($Mcat as $Mcat) {
            $arr[$Mcat->id] = $Mcat->type;
        }
        return $arr;
    }

    public
    function material()
    {
        return $this->belongsTo('App\Material','material_id');
    }
}
