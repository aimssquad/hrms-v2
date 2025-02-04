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

            $data["employee_rs"] = DB::table('change_circumstances_history')
            //->where('emp_code', '=', $employee_code)
            ->where('emid', '=', $reg)
            //->orderBy('emp_code')
            ->orderBy('id','DESC')
            ->get();
            //dd($data);
            return view($this->_routePrefix. '.change-of-circumstances',$data);
        } else {
            return redirect("/");
        }
    }



} //End Class
