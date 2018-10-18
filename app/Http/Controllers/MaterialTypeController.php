<?php

namespace App\Http\Controllers;

use App\Material;
use App\MaterialType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MaterialTypeController extends Controller
{
    public function index()
    {
        return view('adminview.material_type.view_material_type')->with('material_types', MaterialType::getActiveMT());
    }

    public function create()
    {
        $material = Material::getMaterialDropdown();
        return view('adminview.material_type.create_material_type')->with(['material' => $material]);
    }

    public function store(Request $request)
    {
        $unitmaster = new MaterialType();
        if (!$unitmaster->checkMT(request('type'))) {
            return Redirect::back()->withInput()->withErrors('Material Type already exists in the system. Please type a different Material Type');
        } else {
            $vehicle = new MaterialType();
            $vehicle->material_id = request('material_id');
            $vehicle->type = request('type');
            $vehicle->save();
            return redirect('material_type')->with('message', 'Material Type has been added...!');
        }
    }

    public
    function destroy($id)
    {
        $Units = MaterialType::find($id);
        $Units->is_active = 0;
        $Units->save();
        return redirect('material_type')->with('message', 'Material Type has been deleted...!');

    }

    public function edit($id)
    {
        $material_type = MaterialType::find($id);
        $material = Material::getMaterialDropdown();
        return view('adminview.material_type.edit_material_type')->with(['material_type' => $material_type, 'material' => $material]);
    }

    public function update($id, Request $request)
    {
        $vh = new MaterialType();
        if (!$vh->echeckMT(request('type'), $id)) {
            return Redirect::back()->withInput()->withErrors('Material Type already exists in the system. Please type a different Material Type');
        } else {
            $vehicle = MaterialType::find($id);
            $vehicle->material_id = request('material_id');
            $vehicle->type = request('type');
            $vehicle->save();
            return redirect('material_type')->with('message', 'Material Type has been updated...!');
        }
    }
}
