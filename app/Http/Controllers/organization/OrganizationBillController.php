<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Subadmin_bill;
use App\Models\BillingRule;
use Session;
use DB;

class OrganizationBillController extends Controller
{
    public function orgBill(Request $request){
        $email = Session::get("emp_email");
        //dd($email);
        if(!empty($email)){
            $data['org_dtl'] = DB::table('registration')->where('email',$email)->first();
            $data['bills'] = DB::table('subadmin_bills')->where('entity_id',$data['org_dtl']->reg)->get();
            return view('employeer.bills.billing_list',$data);
        } else {
            return redirect('/organization/employerdashboard');
        }  
    }

    public function invoice(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data['bill'] = DB::table('subadmin_bills')->where('id',$id)->first();
            $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
            $data['com_dtl'] = DB::table('sub_admin_registrations')->where('org_code',$data['bill']->org_code)->first();
            //dd($data['bill']);
            return view('employeer.bills.invoice',$data);
        } else {
            redirect('superadmin');
        } 
    }





} // class end
