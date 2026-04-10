<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Helpdesk;
use App\Helpers\Api\Helper;
use Exception;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;
use DB;
use Mail;
class HelpdeskController extends Controller
{

    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Helpdesk';
        $this->_routePrefix = 'employeer.helpdesk';
        $this->_model       = new Helpdesk();
    }

    public function index(){
        try {
            $email = Session::get('emp_email');
            $user_id = Session::get('emid');
            //dd($user_id);
            if (!empty($email)) {
                $tech_support = Helpdesk::where('emid', $user_id)->get();
                return view($this->_routePrefix . '.helpdesk-list', compact('tech_support'));
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function addHelpdesk(){
        try {
            $email = Session::get('emp_email');
            $user_id = Session::get('emid');
            if (!empty($email)) {
                $comdtl = DB::table('registration')->where('email', $email)->select('com_name', 'email')->first();
                if(!$comdtl){
                    return redirect('/');  
                }
                return view($this->_routePrefix . '.add-helpdesk', compact('comdtl'));
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } 
    }

    public function storeHelpdesk(Request $request)
    {
        try {
            $email = Session::get('emp_email');
            $user_id = Session::get('emid');
            if (!empty($email)) {
                $comdtl = DB::table('registration')->where('email', $email)->select('com_name', 'email')->first();
                if(!$comdtl){
                    return redirect('/');  
                }

                $request->validate([
                    "name"    => "required|string|max:255",
                    "email"   => "required|email",
                    "message" => "required|string|min:5",
                    "image"   => "nullable|image|mimes:jpg,jpeg,png|max:2048",
                ]);


                $orgShort = strtoupper(substr($request->name, 0, 3));   // First 3 letters
                $randomNum = rand(10000, 99999);                       // Random 5 digits

                $ticket_no = $orgShort . $randomNum;

                 // Handle image upload
                $imagePath = "";
                if ($request->hasFile("image")) {
                    $imagePath = $request->file("image")->store("helpdesk", "public");
                }

                // Insert into helpdesk table
                $ticketData = [
                    "ticket_no"   => $ticket_no,
                    "name"        => $request->name,
                    "email"       => $request->email,
                    "message"     => $request->message,
                    "image"       => $imagePath,
                    //"employee_id" => $employee_id,
                    "emid"        => $user_id,
                    "status"      => 0,
                    "created_at"  => now(),
                ];

                Helpdesk::insert($ticketData);
                Session::flash('message', 'Technical support added successfully.');
                return redirect('helpdesk');

            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } 
    }

    public function subadminIndex(){
        try {
            $email = Session::get('empsu_email');
            //$user_id = Session::get('empsu_id');
            $emid = DB::table('sub_admin_registrations')->where('email', $email)->where('status','active')->where('verify','approved')->value('reg');
            //dd($emid, $email);
            if (!empty($email)) {
                $tech_support = Helpdesk::where('emid', $emid)->get();
                //dd($tech_support);
                return view('sub-admin.helpdesk.helpdesk-list', compact('tech_support'));
            } else {
                return redirect('/subadmin');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function subadminAddHelpdesk(){
        try {
            $email = Session::get('empsu_email');
            $emid = DB::table('sub_admin_registrations')
                ->where('email', $email)->where('status','active')
                ->where('verify','approved')->value('reg');
                
            if(!$emid){
                return redirect('/subadmin');  
            }

            if (!empty($email)) {
                $comdtl = DB::table('sub_admin_registrations')->where('email', $email)->select('com_name', 'email')->first();
                if(!$comdtl){
                    return redirect('/subadmin');   
                }
                return view('sub-admin.helpdesk.add-helpdesk', compact('comdtl'));
            } else {
                 return redirect('/subadmin');  
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } 
    }

    public function subadminStoreHelpdesk(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            $emid = DB::table('sub_admin_registrations')
                ->where('email', $email)->where('status','active')
                ->where('verify','approved')->value('reg');
                
            if(!$emid){
                return redirect('/subadmin');  
            }

            if (!empty($email)) {
                $comdtl = DB::table('sub_admin_registrations')->where('email', $email)->select('com_name', 'email')->first();
                if(!$comdtl){
                   return redirect('/subadmin');  
                }

                $request->validate([
                    "name"    => "required|string|max:255",
                    "email"   => "required|email",
                    "message" => "required|string|min:5",
                    "image"   => "nullable|image|mimes:jpg,jpeg,png|max:2048",
                ]);


                $orgShort = strtoupper(substr($request->name, 0, 3));   // First 3 letters
                $randomNum = rand(10000, 99999);                       // Random 5 digits

                $ticket_no = $orgShort . $randomNum;

                 // Handle image upload
                $imagePath = "";
                if ($request->hasFile("image")) {
                    $imagePath = $request->file("image")->store("helpdesk", "public");
                }

                // Insert into helpdesk table
                $ticketData = [
                    "ticket_no"   => $ticket_no,
                    "name"        => $request->name,
                    "email"       => $request->email,
                    "message"     => $request->message,
                    "image"       => $imagePath,
                    //"employee_id" => $employee_id,
                    "emid"        => $emid,
                    "status"      => 0,
                    "created_at"  => now(),
                ];

                Helpdesk::insert($ticketData);
                Session::flash('message', 'Technical support added successfully.');
                return redirect('subadmin-helpdesk');

            } else {
                return redirect('/subadmin'); 
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } 
    }

}
