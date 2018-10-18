<?php

namespace App\Http\Controllers;

use App\ItemImages;
use App\ItemMaster;
use App\ItemPrice;
use App\OrderDescription;
use App\OrderMaster;
use App\UserAddress;
use App\UserMaster;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

session_start();

class FrontendController extends Controller
{

    /**************************Login/Registration/profile************************************/
    public function login(Request $request)
    {
        $username = request('email');
        $password = request('password');
        $user = UserMaster::where(['is_active' => 1, 'email' => $username, 'password' => md5($password)])->orWhere(['is_active' => 1, 'contact' => $username, 'password' => md5($password)])->first();
        if ($user != null) {
            $_SESSION['user_master'] = $user;
            return Redirect::back();
        } else
            return Redirect::back()->withInput()->withErrors(array('message' => 'Email or password Invalid'));
    }

    public function postregister()
    {
        $otp = rand(100000, 999999);
        $rc = rand(10000000, 99999999);
        $user = new UserMaster();
        $user->contact = request('contact');;
//        $user->birthday = Carbon::parse(request('dob'))->format('Y-m-d');
        $user->password = md5(request('password'));
        $user->city_id = request('city_id');
        $user->country_id = request('country');
        $user->gender = request('gender');
        $user->otp = $otp;
        $user->rc = "rc" . $rc;
        $user->save();
// Session to store userid only for transactions
        $user_ = new UserMaster();
        $_SESSION["UID"] = $user_::select('id')->where('email', request('email'))->get()->first()->id;
        /////////////////////////////
//        $timeline = Timeline::find($user->timeline_id);
//        $_SESSION['user_timeline'] = $timeline;
//        $_SESSION['user_master'] = $user;
//        file_get_contents("http://63.142.255.148/api/sendmessage.php?usr=connectingone&apikey=A0F25813739CF5A748C8&sndr=CONONE&ph=$contact&message=Dear%20user,%20OTP%20to%20login%20into%20connectingone%20is%20$otp");


//        /***********Mail************/
//        $allmails = [request('email'), 'retinodes.bijendra@gmail.com'];
//
//        foreach ($allmails as $mail) {
//            $email[] = $mail;
//        }
//        if (count($email) > 0) {
//            $mail = new \App\Mail();
//            $mail->to = implode(",", $email);
//            $mail->subject = 'Connecting-one';
//            $siteurl = 'https://www.connecting-one.com/';
//            $username = request('fname') . " " . request('lname');
//            $salutation = request('gender') == 'male' ? "Mr." : "Ms.";
//
//            $message = '<table width="650" cellpadding="0" cellspacing="0" align="center" style="background-color:#ececec;padding:40px;font-family:sans-serif;overflow:scroll"><tbody><tr><td><table cellpadding="0" cellspacing="0" align="center" width="100%"><tbody><tr><td><div style="line-height:50px;text-align:center;background-color:#fff;border-radius:5px;padding:20px"><a href="'.$siteurl.'" target="_blank" ><img src="'.$siteurl.'images/logo.png"></a></div></td></tr><tr><td><div><img src="'.$siteurl.'images/acknowledgement.jpg" style="height:auto;width:100%;" tabindex="0"><div dir="ltr" style="opacity: 0.01; left: 775px; top: 343px;"><div><div class="aSK J-J5-Ji aYr"></div></div></div></div></td></tr><tr><td style="background-color:#fff;padding:20px;border-radius:0px 0px 5px 5px;font-size:14px"><div style="width:100%"><h1 style="color:#007cc2;text-align:center">Thank you '.$salutation.' '.$username.'</h1><p style="font-size:14px;text-align:center;color:#333;padding:10px 20px 10px 20px">Thank you for your registration in www.connecting-one.com is a unique Earning & advertising platform that brings together the socially conscious members & Advertisers.<br   /> Your otp is '.$otp.'</p></div></td></tr></tbody></table></td></tr><tr><td style="padding:20px;font-size:12px;color:#797979;text-align:center;line-height:20px;border-radius:5px 5px 0px 0px">DISCLAIMER - The information contained in this electronic message (including any accompanying documents) is solely intended for the information of the addressee(s) not be reproduced or redistributed or passed on directly or indirectly in any form to any other person.</td></tr></tbody></table>';
//
//            $mail->body = $message;
//            if ($mail->send_mail()) {
//                //return redirect('mail')->withErrors('Email sent...');
//            } else {
//                //return redirect('mail')->withInput()->withErrors('Something went wrong. Please contact admin');
//            }
////            echo $message;
//        }
        /***********Mail************/
    }

    public function home()
    {
        if (isset($_SESSION['user_master'])) {
            $user_ses = $_SESSION['user_master'];
            $user = UserMaster::find($user_ses->id);
            return view('web.home');/*->with(['user' => $user])*/
        } else {
            $_SESSION['user_master'] = null;
            return view('web.home');
        }
    }

    public function my_profile()
    {
        if (isset($_SESSION['user_master'])) {
            $user_ses = $_SESSION['user_master'];
            $user = UserMaster::find($user_ses->id);
            return view('web.my_profile')->with(['user' => $user]);
        } else {
            return Redirect::back()->withInput()->withErrors(array('message' => 'Please login first'));
        }
    }

    public function profile_update(Request $request)
    {
        $user = $_SESSION['user_master'];
        $user = UserMaster::find($user->id);
        $email = request('email');
        $mobile = request('contact');
        $useremail = DB::selectone("SELECT * FROM `users` WHERE id != $user->id and email = '$email'");
        $usermob = DB::selectone("SELECT * FROM `users` WHERE id != $user->id and contact = '$mobile'");
        if (isset($useremail)) {
            return 'Email is already exist';
        } elseif (isset($usermob)) {
            return 'Contact is already exist';
        } else {
            $user->name = request('name');
            $user->email = request('email');
            $user->contact = request('contact');
            $file = $request->file('profile_img');
            if ($request->file('profile_img') != null) {
                $destination_path = 'u_img/' . $user->id . '/';
                $filename = str_random(6) . '_' . $file->getClientOriginalName();
                $file->move($destination_path, $filename);
                $user->profile_img = $filename;
            }
            $user->save();
            return 'success';
        }
    }
    /**************************Login/Registration/profile************************************/


    /**************************Items************************************/
    public function product_details()
    {
        return view('web.product_details');
    }

    public function product_feedback()
    {
        return view('web.product_feedback');
    }

    public function product_list()
    {
        $categories = DB::table('category_master')->where('is_active', '1')->get();
        return view('web.product_list')->with(['categories' => $categories]);
    }

    public function view_item()
    {
        $item_id = request('item_id');
        $item = ItemMaster::find($item_id);
        $item_images = ItemImages::where(['item_master_id' => $item_id])->get();
        $item_prices = ItemPrice::where(['item_master_id' => $item_id])->get();
        return view('web.view_product')->with(['item' => $item, 'item_images' => $item_images, 'item_prices' => $item_prices]);
    }

    public function getmoreproducts()
    {
        $category_id = request('category_id');
        $qry = '';

        $all = "SELECT i.* FROM item_master i, item_category ic where ic.item_master_id = i.id";
        $by_id = "SELECT i.* FROM item_master i, item_category ic where ic.item_master_id = i.id and ic.category_id = $category_id";
        $a = ($category_id == 0) ? $all : $by_id;
        $products_c = DB::select($a);
        $numrows = count($products_c);
        $rowsperpage = 8;
        $totalpages = ceil($numrows / $rowsperpage);
        $limit = request('limit');
        if (request('currentpage') != '' && is_numeric(request('currentpage'))) {
            $currentpage = (int)request('currentpage');
        } else {
            $currentpage = 1;  // default page number
        }

        if ($currentpage < 1) {
            $currentpage = 1;
        }

        $offset = ($currentpage - 1) * $rowsperpage;
        $all = "SELECT i.* FROM item_master i, item_category ic where ic.item_master_id = i.id ORDER BY i.id DESC LIMIT $offset,$rowsperpage";
        $by_id = "SELECT i.* FROM item_master i, item_category ic where ic.item_master_id = i.id and ic.category_id = $category_id ORDER BY i.id DESC LIMIT $offset,$rowsperpage";
        $s = ($category_id == 0) ? $all : $by_id;
//        $s = "SELECT i.* FROM item_master i, item_category ic where ic.item_master_id = i.id and ic.category_id = $category_id ORDER BY i.id DESC LIMIT $offset,$rowsperpage";
        $items = DB::select($s);
        if (count($items) > 0) {
            return view('web.product_load')->with(['items' => $items, 'items_count' => $numrows]);
        }
    }
    /**************************Items************************************/


    /**************************Address************************************/
    public function getexistaddress()
    {
        $address = UserAddress::find(request('address_id'));
        return response()->json(array('name' => $address->name, 'email' => $address->email, 'contact' => $address->contact, 'address' => $address->address));
    }

    public function address_update()
    {
        if (request('address_id') > 0) {
            $address = UserAddress::find(request('address_id'));
            $address->name = request('name');
            $address->email = request('email');
            $address->contact = request('contact');
            $address->address = request('address');
            //$address->city = request('name');
            $address->save();
            return 'success';
        } else {
            $new_add = new UserAddress();
            $new_add->name = request('name');
            $new_add->email = request('email');
            $new_add->contact = request('contact');
            $new_add->address = request('address');
//            $new_add->city = request('name');
            $new_add->save();
            return 'success';
        }
    }
    /**************************Address************************************/


    /**************************Cart************************************/
    public function mycart()
    {
        return view('web.mycart');
    }
    /**************************Cart************************************/


    /**************************Checkout Confirm************************************/
    public function checkout()
    {
        if (isset($_SESSION['user_master'])) {
            $user_ses = $_SESSION['user_master'];
            $user = UserMaster::find($user_ses->id);
            return view('web.checkout')->with(['user' => $user]);
        } else {
            return Redirect::back()->withInput()->withErrors(array('message' => 'Please login first'));
        }

    }

    public function confirm_order(Request $request)
    {
        $cart = Cart::content();
        $user = $_SESSION['user_master'];
        if (count($cart) == 0) {
            return redirect('checkout')->withInput()->withErrors('Your cart is empty');
        } else {
            $order = new OrderMaster();
            $order->order_no = rand(100000, 999999);
            $order->user_id = $user->id;
            $order->address_id = request('address_id');
            $order->status = 'Processing';
            $order->delivery_charge = request('delivery_charge');;
            foreach ($cart as $row) {
                $order_des = new OrderDescription();
                $order_des->order_master_id = $order->id;
                $order_des->item_master_id = $row->Id;
                $order_des->qty = $row->qty;
                $order_des->unit_price = $row->price;
                $order_des->total = $row->price * $row->qty;
                $order_des->save();
            }
            Cart::destroy();
            return redirect('mycart')->with('message', 'Your order has been placed...you will get confirmation mail');
        }
    }
    /**************************Checkout Confirm************************************/


    /**************************Orders************************************/
    public function order_list()
    {
        return view('web.order_list');
    }
    /**************************Orders************************************/

}
