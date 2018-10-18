<?php

namespace App\Http\Controllers;

use App\AdminMaster;
use App\ClientRequest;
use App\ClientUnload;
use App\LocationMaster;
use App\LoginModel;
use App\ManagerRequest;
use App\Material;
use App\MaterialType;
use App\Unit;
use App\UserMaster;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

session_start();

class AdminController extends Controller
{
    public function admin()
    {
        if (isset($_SESSION['admin_master'])) {
//            $alldata = Categorymaster::where(['is_active' => 1])->paginate(10);
//            $allcat = Categorymaster::where(['is_active' => 1])->get();
            $total_user = UserMaster::where('user_type', '!=', 'admin')->count();
            $total_staff = UserMaster::where(['user_type' => 'staff'])->count();
            $total_client = UserMaster::where(['user_type' => 'supervisor'])->count();
            $total_supervisor = UserMaster::where(['user_type' => 'client'])->count();
            $loaded_items = ManagerRequest::limit(5)->get();
            $requests = ClientRequest::limit(5)->get();
            return view('adminview.dashboard')->with(['total_user' => $total_user, 'total_staff' => $total_staff, 'total_client' => $total_client, 'total_supervisor' => $total_supervisor, 'loaded_items' => $loaded_items, 'requests' => $requests]);
        } else {
            return redirect('/');
        }
    }

    public function category()
    {

        if ($_SESSION['admin_master'] != null) {
            $alldata = Categorymaster::where(['is_active' => 1])->paginate(10);
            $allcat = Categorymaster::where(['is_active' => 1])->get();
            $alldata1 = Categorymaster::where(['is_active' => 1])->get();
            return view('adminview.category', ['alldata' => $alldata, 'alldata1' => $alldata1, 'allcat' => $allcat])->with('no', 1);
        } else {
            return redirect('/adminlogin');
        }

    }

    public function adminlogin()
    {
        if (isset($_SESSION['admin_master'])) {
            return redirect('/admin');
        } else {
            return view('adminview.adminlogin');
        }
    }

    public function logincheck()
    {
        $username = request('username');
        $password = md5(request('password'));
        $user = LoginModel::where(['username' => $username, 'password' => $password, 'is_active' => 1])->first();
        if ($user != null) {
            $_SESSION['admin_master'] = $user;
            return 'success';
        } else {
            /*return redirect('/adminlogin')->withInput()->withErrors(array('message' => 'UserName or password Invalid'));*/
            return 'fail';

        }
    }

    /*******************Admin**********************/
    public function loaded_items()
    {
        $loaded_items = ManagerRequest::get();
        return view('adminview.manager.loaded_items')->with(['loaded_items' => $loaded_items]);
    }

    /************Loaded Update************/
    public function edit_loaded_items($id)
    {
        $loaded_items = ManagerRequest::find($id);
        $vehicles = Vehicle::getVehicleDropdown();
        $locations = LocationMaster::getLocationDropdown();
        $material_types = MaterialType::getMaterialTypeDropdown();
        $materials = Material::getMaterialDropdown();
        $units = Unit::getUnitDropdown();
        return view('adminview.manager.edit_loaded_items')->with(['loaded_items' => $loaded_items, 'vehicles' => $vehicles, 'locations' => $locations, 'materials' => $materials, 'material_types' => $material_types, 'units' => $units]);
    }

    public function update_loaded_items()
    {
        $id = request('id');
        $loaded_items = ManagerRequest::find($id);
        $loaded_items->challan_no = request('challan_no');
        $loaded_items->location_id = request('location_id');
        $loaded_items->material_id = request('material_id');
        $loaded_items->material_type_id = request('material_type_id');
        $loaded_items->load_qty = request('load_qty');
        $loaded_items->unit_id = request('unit_id');
        $loaded_items->destination_address = request('destination_address');
        $loaded_items->vehicle_id = request('vehicle_id');
        $loaded_items->save();
        return redirect('loaded_items')->with('message', 'Loaded items has been updated...!');
    }
    /************Loaded Update************/

    /************Loaded Update************/
    public function edit_unloaded_items($id)
    {
        $unloaded_items = ClientUnload::find($id);
        $vehicles = Vehicle::getVehicleDropdown();
        $locations = LocationMaster::getLocationDropdown();
        $material_types = MaterialType::getMaterialTypeDropdown();
        $materials = Material::getMaterialDropdown();
        $units = Unit::getUnitDropdown();
        return view('adminview.client.edit_unloaded_items')->with(['unloaded_items' => $unloaded_items, 'vehicles' => $vehicles, 'locations' => $locations, 'materials' => $materials, 'material_types' => $material_types, 'units' => $units]);
    }

    public function update_unloaded_items()
    {
        $id = request('id');
        $unloaded_items = ClientUnload::find($id);
        $unloaded_items->challan_no = request('challan_no');
        $unloaded_items->location_id = request('location_id');
        $unloaded_items->material_id = request('material_id');
        $unloaded_items->material_type_id = request('material_type_id');
        $unloaded_items->unload_qty = request('unload_qty');
        $unloaded_items->unit_id = request('unit_id');
        $unloaded_items->vehicle_id = request('vehicle_id');
        $unloaded_items->save();
        return redirect('unloaded_items')->with('message', 'Unloaded items has been updated...!');
    }

    /************Loaded Update************/

    public function delete_loaded_items()
    {
        if (request('loaded_id') != null) {
            foreach (request('loaded_id') as $loaded_id) {
                ManagerRequest::find($loaded_id)->delete();
            }
            return redirect('loaded_items')->with('message', 'Loaded items has been deleted...!');
        } else {
            return redirect('loaded_items')->withErrors('Please select any record to delete...!');
        }
    }


    public function search_loaded_items()
    {
        $start_date = Carbon::parse(request('start_date'));
        $end_date = Carbon::parse(request('end_date'))->format('Y-m-d');
        $e_date = $end_date . ' 23:59:00';
        $loaded_items = ManagerRequest::where('loaded_time', '>=', $start_date)->where('loaded_time', '<=', $e_date)->get();
        return view('adminview.manager.loaded_items')->with(['loaded_items' => $loaded_items]);
    }

    public function unloaded_items()
    {
        $unloaded_items = ClientUnload::get();
      /*  $unloaded_items = DB::select("SELECT cu.id,cu.challan_no,(SELECT v.vehicle_no from vehicle v where v.id = cu.vehicle_id) as vehicle_no,(SELECT m.name from material m where m.id = cu.material_id) as material_name, (SELECT mt.type from material_type mt where mt.id = cu.material_type_id) as material_type, (SELECT u.unit from unit u where u.id = cu.unit_id) as unit,
(SELECT uu.name from users uu where uu.id = cu.unload_by) as client_name, cu.unload_qty, cu.unloaded_time, mr.challan_no as loaded_challan from client_unload cu, manager_request mr where cu.vehicle_id = mr.vehicle_id order by cu.id desc");*/
        return view('adminview.client.unloaded_items')->with(['unloaded_items' => $unloaded_items]);
    }

    public function delete_unloaded_items()
    {
        if (request('unloaded_id') != null) {
            foreach (request('unloaded_id') as $unloaded_id) {
                $loaded_items = ClientUnload::find($unloaded_id)->delete();
            }
            return redirect('unloaded_items')->with('message', 'UnLoaded items has been deleted...!');
        } else {
            return redirect('unloaded_items')->withErrors('Please select any record to delete...!');
        }
    }

    public function search_unloaded_items()
    {
        $start_date = Carbon::parse(request('start_date'));
        $end_date = Carbon::parse(request('end_date'))->format('Y-m-d');
        $e_date = $end_date . ' 23:59:00';
        $unloaded_items = ClientUnload::where('unloaded_time', '>=', $start_date)->where('unloaded_time', '<=', $e_date)->get();
        return view('adminview.client.unloaded_items')->with(['unloaded_items' => $unloaded_items]);
    }

    public function client_request_list()
    {
        $requests = ClientRequest::get();
        return view('adminview.client.client_request_list')->with(['requests' => $requests]);
    }

    public function material_comparision()
    {
//        $requests = DB::select("SELECT m.name as m_name, (SELECT mtt.type from material_type mtt where mr.material_type_id = mtt.id) as loaded_type, (SELECT mtu.type from material_type mtu where cu.material_type_id = mtu.id) as unloaded_type, cu.unload_qty, mr.challan_no as loaded_challan, cu.challan_no as unloaded_challan, mr.load_qty, u.unit, v.vehicle_no, mr.estimate_deliver_time, cu.unloaded_time, cu.challan_no, mr.loaded_time FROM manager_request mr, client_unload cu, vehicle v, material m, unit u WHERE mr.vehicle_id = cu.vehicle_id and cu.material_id = m.id and cu.vehicle_id = v.id and cu.unit_id = u.id order by cu.unloaded_time desc");
        $requests = DB::select("SELECT (SELECT m.name from material m where m.id = cu.material_id) as m_name, (SELECT mtt.type from material_type mtt where mr.material_type_id = mtt.id) as loaded_type, (SELECT mtu.type from material_type mtu where cu.material_type_id = mtu.id) as unloaded_type, cu.unload_qty, mr.challan_no as loaded_challan, cu.challan_no as unloaded_challan,
mr.load_qty, (SELECT u.unit from unit u where cu.unit_id = u.id) as unit,(SELECT v.vehicle_no from vehicle v where cu.vehicle_id = v.id) as vehicle_no, cu.unloaded_time, cu.challan_no, mr.loaded_time FROM manager_request mr, client_unload cu WHERE mr.vehicle_id = cu.vehicle_id and mr.challan_no=cu.load_challan_no UNION SELECT (SELECT m.name from material m where m.id = cu.material_id) as m_name, '-' as loaded_type, (SELECT mtu.type from material_type mtu where cu.material_type_id = mtu.id) as unloaded_type, cu.unload_qty, '-' as loaded_challan, cu.challan_no as unloaded_challan, '0' as load_qty, (SELECT u.unit from unit u where cu.unit_id = u.id) as unit, (SELECT v.vehicle_no from vehicle v where cu.vehicle_id = v.id) as vehicle_no, cu.unloaded_time, cu.challan_no, '-' as loaded_time FROM  client_unload cu WHERE cu.load_challan_no is null");
        return view('adminview.client.comparision')->with(['requests' => $requests]);
    }

    public function petrol_requests()
    {
        $petrols = DB::select("SELECT po.id, (select v.vehicle_no from vehicle v where v.id = po.vehicle_id) as vehicle_no, po.qty, (select un.unit from unit un where un.id = po.unit_id) as unit, (select u.name from users u where u.id = po.order_by) as staff, po.created_time, po.is_active, po.is_done, (select us.name from users us where us.id = po.done_by) as supervisor  FROM petrol_order po, unit un WHERE po.is_active = 1");
        return view('adminview.manager.petrol_requests_list')->with(['petrols' => $petrols]);
    }

    public
    function change_password()
    {
        $curr_pass = $_SESSION['admin_master']->password;
        if (md5(request('oldpassword')) == $curr_pass) {
            $user = AdminMaster::find($_SESSION['admin_master']->id);
            $user->password = md5(request('newpassword'));
            $user->save();
            $_SESSION['admin_master'] = $user;
            echo 'ok';
        } else
            echo 'Incorrect';
    }

    public function users()
    {
        $users = UserMaster::where('user_type', '!=', 'admin')->get();
        return view('adminview.users')->with(['users' => $users]);
    }

    public function edit_user($id)
    {
        $user = UserMaster::find($id);
        return view('adminview.edit_user')->with(['user' => $user]);
    }

    public function update_user()
    {
        $id = request('id');
        $user = UserMaster::find($id);
        $user->user_type = request('user_type');
        $user->type = request('user_type') == 'staff' ? 'staff' : request('type');
        $user->save();
        return redirect('users')->with('message', 'User has been updated...!');
    }

    public
    function approved($id)
    {
        $users = ClientRequest::find($id);
        $users->is_approved = 1;
        $users->save();
//        return redirect('client_requests')->with('message', 'Request has been approved...!');
    }

    public
    function inactive($id)
    {
        $users = UserMaster::find($id);
        $users->is_active = 0;
        $users->save();
        return redirect('users')->with('message', 'User has been Inactivated...!');

    }

    public
    function active($id)
    {
        $users = UserMaster::find($id);
        $users->is_active = 1;
        $users->save();
        return redirect('users')->with('message', 'User has been activated...!');

    }
    /*******************Admin**********************/
}
