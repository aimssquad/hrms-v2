<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Session;

class CircumstanceController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.circumstances';
        //$this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request){
        return view($this->_routePrefix. '.dashboard');
    }

    public function viewchangecircumstanceseditadd()
    {
        if (!empty(Session::get("emp_email"))) {
            $reg = Session::get("emid");
            // $Roledata = DB::table("registration")
            //     ->where("status", "=", "active")
            //     ->where("email", "=", $email)
            //     ->first();
            $data["employee_rs"] = DB::table("change_circumstances")
                ->where("emid", "=", $reg)
                ->orderBy("id", "ASC")
                ->get();
            return view($this->_routePrefix. '.change-of-circumstances',$data);
            //return view("employee/change-of-circumstances", $data);
        } else {
            return redirect("/");
        }
    }



} //End Class
