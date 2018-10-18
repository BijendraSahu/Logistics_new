<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

session_start();

class UnitController extends Controller
{
    public function index()
    {
        return view('adminview.unit.view_unit_master')->with('units', Unit::getActiveUnit());;
    }

    public function create()
    {
        return view('adminview.unit.create_unit_master');
    }

    public function store(Request $request)
    {
        $unitmaster = new Unit();
        if (!$unitmaster->checkUnitName(request('name'))) {
            return Redirect::back()->withInput()->withErrors('Unit already exists in the system. Please type a different unit.');
        } else {
            $Units = new Unit();
            $Units->unit = request('name');
            $Units->save();
            return redirect('unit')->with('message', 'Unit has been added...!');
        }
    }

    public
    function destroy($id)
    {
        $Units = Unit::find($id);
        $Units->is_active = 0;
        $Units->save();
        return redirect('unit')->with('message', 'Unit has been deleted...!');

    }

    public function edit($id)
    {
        $UnitMaster = unit::find($id);
        return view('adminview.unit.edit_unit_master')->with(['unit' => $UnitMaster]);
    }

    public function update($id, Request $request)
    {
        $unitMaster = Unit::find($id);
        $unitMaster->unit = request('name');
        $unitMaster->save();
//        return Redirect::back();
        return redirect('unit')->with('message', 'Unit has been updated...!');

    }
}
