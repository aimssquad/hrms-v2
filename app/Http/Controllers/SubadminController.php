<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use Exception;
use Session;
use DB;

class SubadminController extends Controller
{
    public function profile(Request $request){
        $email = Session::get('empsu_email');
        //dd($email);
        if (!empty($email)) {
            $data['companies_rs'] = DB::table('sub_admin_registrations')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
          
            return view('sub-admin.subadmin_profile',$data);

        }else{
            return redirect('/');
        }
    }

    public function editProfile($id)
    {
        //dd('ok');
        try {
            $email = Session::get('empsu_email');
            // dd($email);
            if (!empty($email)) {
                $data['Roledata'] = DB::table('sub_admin_registrations')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['application_status_tareq'] = DB::table('tareq_app')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->first();

                $data['cuurenci_master'] = DB::table('location_countries')->get();
                $data['nat_or_master'] = DB::table('nat_or')->get();
                $data['type_or_master'] = DB::table('type_or')->get();
                $data['employee_upload_rs'] = DB::table('company_upload')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                $data['employee_or_rs'] = DB::table('company_employee')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                $data['user'] = DB::table('users')->where('email',$email)->select('password')->first();     
                //dd($data['Roledata']);
                return view('sub-admin.edit-subadmin',$data);
                //return View('company/edit-company', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function updateSubadminProfile(Request $request)
    {
        //dd('okk');
        //dd($request->all());
        try {
            if (!empty(Session::get('empsu_email'))) {

                //dd($request->all());
                $email = Session::get('empsu_email');
                $password = $request->validate([
                    'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                ]);
                //dd($password);
                $existingCompanyInfo = DB::table('sub_admin_registrations')->where('status', '=', 'active')->where('email', $email)->first();
                //dd($existingCompanyInfo->licence);

                if ($request->has('image')) {

                    $file = $request->file('image');
                    $extension = $request->image->extension();
                    $path = $request->image->store('subadmin', 'public');
                    $dataimg = array(
                        'logo' => $path,
                    );
                    //dd($dataimg);
                    DB::table('sub_admin_registrations')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
                }
                //dd('ok');
                if ($request->has('proof')) {

                    $file1 = $request->file('proof');
                    $extension1 = $request->proof->extension();
                    $path1 = $request->proof->store('proof', 'public');
                    $dataimg = array(
                        'proof' => $path1,
                    );
                    DB::table('sub_admin_registrations')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
                }

                if ($request->has('sub_admin_registrations')) {

                    $file1 = $request->file('key_proof');
                    $extension1 = $request->key_proof->extension();
                    $path1 = $request->key_proof->store('key_proof', 'public');
                    $dataimgh = array(
                        'key_proof' => $path1,
                    );
                    DB::table('sub_admin_registrations')->where('status', '=', 'active')->where('email', $email)->update($dataimgh);
                }

                if ($request->hasFile('level_proof')) {
                    $file1 = $request->file('level_proof');
                    $filename = time() . '.' . $file1->getClientOriginalExtension();
                    $path1 = $file1->storeAs('level_proof', $filename, 'public');
                    $dataimgf = [
                        'level_proof' => $path1,  // Store the relative path
                    ];
                    DB::table('sub_admin_registrations')
                        ->where('status', '=', 'active')
                        ->where('email', $email)
                        ->update($dataimgf);
                }
                $dataup = array(
                    'com_name' => $request->com_name,
                    'f_name' => $request->f_name,

                    'l_name' => $request->l_name,

                    'p_no' => $request->p_no,
                    'pan' => $request->pan,
                    'address' => $request->address,
                    'website' => $request->website,
                    'land' => $request->land,
                    'fax' => $request->fax,
                    'pass' => $request->password,

                    'key_person' => $request->key_person,
                    'level_person' => $request->level_person,

                    'key_f_name' => $request->key_f_name,
                    'key_f_lname' => $request->key_f_lname,
                    'key_designation' => $request->key_designation,
                    'key_phone' => $request->key_phone,
                    'key_email' => $request->key_email,
                    'key_bank_status' => $request->key_bank_status,
                    'key_bank_other' => $request->key_bank_other,

                    'level_f_name' => $request->level_f_name,
                    'level_f_lname' => $request->level_f_lname,
                    'level_designation' => $request->level_designation,
                    'level_phone' => $request->level_phone,
                    'level_email' => $request->level_email,
                    'level_bank_status' => $request->level_bank_status,
                    'level_bank_other' => $request->level_bank_other,

                    'trad_status' => $request->trad_status,
                    'trad_other' => $request->trad_other,
                    'penlty_status' => $request->penlty_status,
                    'penlty_other' => $request->penlty_other,
                    'bank_status' => $request->bank_status,
                    'bank_other' => $request->bank_other,

                    'com_reg' => $request->com_reg,
                    'com_type' => $request->com_type,
                    'com_year' => $request->com_year,
                    'com_nat' => $request->com_nat,
                    'no_em' => $request->no_em,
                    'work_per' => $request->work_per,
                    'no_dire' => $request->no_dire,

                    'bank_name' => $request->bank_name,
                    'acconut_name' => $request->acconut_name,
                    'organ_email' => $request->organ_email,
                    'sort_code' => $request->sort_code,
                    'others_type' => $request->others_type,

                    'nature_type' => $request->nature_type,
                    'no_em_work' => $request->no_em_work,

                    'country' => $request->country,
                    'currency' => $request->currency,
                    'desig' => $request->desig,
                    'trad_name' => $request->trad_name,
                    'con_num' => $request->con_num,
                    'authemail' => $request->authemail,

                    'address2' => $request->address2,
                    'road' => $request->road,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'updated_at' => date('Y-m-d'),

                    'licence' => $request->licence,
                    'verify' => $request->verify,
                    'verified_on' => $request->verified_on,
                    //'status' => $request->status,
                    'license_type' => $request->license_type,

                    'sun_status' => $request->sun_status,
                    'sun_time' => $request->sun_time,
                    'sun_close' => $request->sun_close,

                    'mon_status' => $request->mon_status,
                    'mon_time' => $request->mon_time,
                    'mon_close' => $request->mon_close,

                    'tue_status' => $request->tue_status,
                    'tue_time' => $request->tue_time,
                    'tue_close' => $request->tue_close,

                    'wed_status' => $request->wed_status,
                    'wed_time' => $request->wed_time,
                    'wed_close' => $request->wed_close,

                    'thu_status' => $request->thu_status,
                    'thu_time' => $request->thu_time,
                    'thu_close' => $request->thu_close,

                    'fri_status' => $request->fri_status,
                    'fri_time' => $request->fri_time,
                    'fri_close' => $request->fri_close,

                    'sat_status' => $request->sat_status,
                    'sat_time' => $request->sat_time,
                    'sat_close' => $request->sat_close,

                );

                $Roledatauseer = DB::table('sub_admin_registrations')
                    ->where('status', '=', 'active')
                    ->where('reg', '=', $request->reg)
                    ->first();

                // if ($Roledatauseer->created_at != '' && $Roledatauseer->updated_at == '') {

                //     $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email);
                //     $toemail = 'sales@skilledworkerscloud.co.uk';
                //     Mail::send('mailorupnew', $data, function ($message) use ($toemail) {
                //         $message->to($toemail, 'Skilledworkescloud')->subject
                //             ('Organisation Update');
                //         $message->from('noreply@skilledworkerscloud.co.uk', 'Skilledworkescloud');
                //     });
                // }

                DB::table('sub_admin_registrations')->where('status', '=', 'active')->where('reg', $request->reg)->update($dataup);
                DB::table('users')->where('status', '=', 'active')->where('employee_id', $request->reg)->update($password);
                Session::flash('message', 'Partner information successfully updated.');
                return redirect('subadmin/profile');
                
            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function allOrganizationEmployee(Request $request)
    {
        $email = Session::get('empsu_email');
        if (!empty($email)) {
            //$email = Session::get('empsu_email');
            if($request->emid !='' && $request->verify_status != ''){
                Session::flashInput($request->input());
                $subAdmin = DB::table('sub_admin_registrations')
                ->where('email', '=', $email)
                ->where('status', '=', 'active')
                ->first(); 
                //dd($subAdmin->org_code);
                $data['totalActiveOrganizations'] = DB::table('registration')
                ->where('org_code', $subAdmin->org_code)
                ->where('status', 'active')
                ->where('verify', 'approved')
                ->get();
                $data['employeeList'] = DB::table('employee')
                ->where('emid', $request->emid)
                ->where('verify_status', $request->verify_status)
                ->get();
                return view('sub-admin.organization.employee-list',$data);
                //dd("$request->emid,$request->verify_status");
            } else {
                
                    $subAdmin = DB::table('sub_admin_registrations')
                        ->where('email', '=', $email)
                        ->where('status', '=', 'active')
                        ->first();
                    if ($subAdmin) {
                        $data['totalActiveOrganizations'] = DB::table('registration')
                            ->where('org_code', $subAdmin->org_code)
                            ->where('status', 'active')
                            ->where('verify', 'approved')
                            ->get();
        
                        $regValues = $data['totalActiveOrganizations']->pluck('reg')->toArray();
        
                        // Get all employees linked to the active organizations
                        $data['employeeList'] = DB::table('employee')
                            ->whereIn('emid', $regValues)
                            //->where('verify_status', 'approved')
                            ->get();
                            //dd($data);
                        return view('sub-admin.organization.employee-list',$data);
                    } else {
                        return redirect('subadmin')->with('error', 'Invalid sub-admin details');
                    }
            }
        } else {
            return redirect('subadmin');
        }   
    }






} // End Class
