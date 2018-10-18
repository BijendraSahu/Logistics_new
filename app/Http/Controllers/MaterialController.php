<?php

namespace App\Http\Controllers;

use App\LocationMaster;
use App\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MaterialController extends Controller
{
    public function index()
    {
        return view('adminview.material.view_material')->with('materials', Material::getActiveMaterial());
    }

    public function create()
    {
        $locations = LocationMaster::getLocationDropdown();
        return view('adminview.material.create_material')->with(['locations' => $locations]);
    }

    public function store(Request $request)
    {
        $ln = new Material();
        if (!$ln->checkMaterialName(request('name'))) {
            return Redirect::back()->withInput()->withErrors('Material name already exists in the system. Please type a different Material name.');
        } else {
            $location = new Material();
            $location->location_id = request('location_id');
            $location->name = request('name');
            $location->save();
            return redirect('material')->with('message', 'Material has been added...!');
        }
    }

    public
    function destroy($id)
    {
        $location = Material::find($id);
        $location->is_active = 0;
        $location->save();
        return redirect('material')->with('message', 'Material has been deleted...!');

    }

    public function edit($id)
    {
        $material = Material::find($id);
        $locations = LocationMaster::getLocationDropdown();
        return view('adminview.material.edit_material')->with(['material' => $material, 'locations' => $locations]);
    }

    public function update($id, Request $request)
    {
        $location = Material::find($id);
        $location->location_id = request('location_id');
        $location->name = request('name');
        $location->save();
        return redirect('material')->with('message', 'Material has been updated...!');

    }
}
