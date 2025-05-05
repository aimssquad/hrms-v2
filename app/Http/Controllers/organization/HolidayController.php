<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use Validator;
use view;
use App\Models\User;
use App\Models\Employee;
use App\Models\Registration;
use App\Models\HolidayType;
use App\Models\Holiday2Type;
use App\Models\HolidayApply;
use App\Models\Holiday;
use Exception;

class HolidayController extends Controller
{
    //
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.holiday';
        //$this->_model       = new CompanyJobs();
    }

    public function dashboard(Request $request){
        if (!empty(Session::get("emp_email"))) {
            $reg = Session::get("emid");
            // $Roledata = Registration::where("status", "=", "active")
            //         ->where("email", "=", $email)
            //         ->first();
            $data["holiday_list_count"] = Holiday::where("holiday.emid", "=", $reg)->count();
            $data["holiday_type_count"] = HolidayType::where("emid", "=", $reg)->count();
            //dd($data);
            return view($this->_routePrefix . '.dashboard',$data);
        }
    }

    public function holidayList(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $reg = Session::get("emid");
                // $Roledata = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                // $data["Roledata"] =Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();

                $data["holiday_rs"] = Holiday::where("holiday.emid", "=", $reg)
                    ->select("holiday_type.name", "holiday.*")
                    ->join(
                        "holiday_type",
                        "holiday.holiday_type",
                        "=",
                        "holiday_type.id"
                    )
                    ->get();
                return view($this->_routePrefix . '.holiday-list',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    
    public function addHolidayList(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $reg = Session::get("emid");
                // $Roledata = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                // $data["Roledata"] = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                $data["holiday_type"] = HolidayType::where("emid", "=", $reg)
                    ->get();
                // dd($data);
                //return view("holiday/add-holiday", $data);
                return view($this->_routePrefix . '.add-holiday-list',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveHolidayList(Request $request)
    {  
        //dd('okkk');
        try {
            if (!empty(Session::get("emp_email"))) {
                $reg = Session::get("emid");
                // $Roledata =Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                // $data["Roledata"] = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();

                //echo "<pre>";print_r($request->all()); exit;
                $validator = Validator::make(
                    $request->all(),
                    [
                        "years" => "required",
                        "from_date" => "required",
                        "to_date" => "required",
                        "month" => "required",
                        "day" => "required",
                        "holiday_descripion" => "required",
                    ],
                    [
                        "years.required" => "Year Required",
                        "from_date.required" => "From Date Required",
                        "to_date.required" => "To Date Required",
                        "month.required" => "Month Required",
                        "day.required" => "Day Required",
                        "holiday_descripion.required" =>
                            "Holiday Descripion Required",
                    ]
                );

                //$data = $request->all();

                //print_r($request->all()); exit;
                $monthYear = explode("-", $request->from_date);
                $data = [
                    "years" => $monthYear[0],
                    "month" => $monthYear[1],
                    "from_date" => $request->from_date,
                    "to_date" => $request->to_date,
                    "day" => $request->day,
                    "emid" => $reg,
                    "weekname" => $request->weekname,
                    "holiday_type" => $request->holiday_type,
                    "updated_at" => date("Y-m-d h:i:s"),
                    "created_at" => date("Y-m-d h:i:s"),
                    "holiday_descripion" => $request->holiday_descripion,
                ];

                if (!empty($request->id)) {
                     Holiday::where("id", $request->id)
                        ->update($data);
                } else {
                     Holiday::insert($data);
                }

                Session::flash(
                    "message",
                    "Holiday Information Successfully Saved."
                );
                return redirect("organization/holiday-list");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function deleteHoliday($holiday_id)
{
    try {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");
            $Roledata = Registration::where("status", "=", "active")
                ->where("email", "=", $email)
                ->first();

            if (!$Roledata) {
                return redirect("/")->with("error", "Unauthorized access.");
            }

            $holiday = Holiday::find($holiday_id);
            if (!$holiday) {
                return redirect("organization/holiday-list")->with("error", "Holiday not found.");
            }

            $holiday->delete();

            Session::flash("message", "Holiday Successfully Deleted.");
            return redirect("organization/holiday-list");
        } else {
            return redirect("/");
        }
    } catch (Exception $e) {
        throw new \App\Exceptions\FrontException($e->getMessage());
    }
}


    public function getHolidayDtl($holiday_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $reg = Session::get("emid");
                // $Roledata = DB::table("registration")
                //     ->where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                // $data["Roledata"] = DB::table("registration")
                //     ->where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();

                $data["holidaydtl"] = DB::Table("holiday")
                    ->where("id", $holiday_id)
                    ->first();
                // dd($data);
                $data["holiday_type"] = DB::table("holiday_type")
                    ->where("emid", "=", $reg)
                    ->get();
                //return view("holiday/add-holiday", $data);
                return view($this->_routePrefix . '.add-holiday-list',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewHolidayTypeDetails()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $reg = Session::get("emid");
                // $Roledata = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                // $data["Roledata"] = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();

                $data["holiday_rs"] = HolidayType::where("emid", "=", $reg)
                    ->select("*")
                    ->get();
                // dd($data['holiday_rs']);

                //return view("holiday/holiday-type", $data);
                return view($this->_routePrefix . '.holiday-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function viewAddHolidayType()
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                // dd($data);
                //return view("holiday/add-holiday-type", $data);
                return view($this->_routePrefix . '.add-holiday-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function saveHolidayTypeData(Request $request)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $reg = Session::get("emid");
                // $Roledata = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();
                // $data["Roledata"] = Registration::where("status", "=", "active")
                //     ->where("email", "=", $email)
                //     ->first();

                //echo "<pre>";print_r($request->all()); exit;
                $validator = Validator::make(
                    $request->all(),
                    [
                        "name" => "required",
                    ],
                    [
                        "name.required" => "Holiday Type Required",
                    ]
                );

                if ($validator->fails()) {
                    return redirect("organization/add-holiday-type")
                        ->withErrors($validator)
                        ->withInput();
                }
                $data = [
                    "name" => $request->name,

                    "emid" => $reg,
                ];
                
                if (!empty($request->id)) {
                    
                    $data=db::table('holiday_type')->where("id", $request->id)
                        ->update($data);
                        
                } else {
                     
                     HolidayType::insert($data);
                }

                Session::flash(
                    "message",
                    "Holiday Type Information Successfully Saved."
                );
                return redirect("organization/holiday-type");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    //Delete Holiday Type 
    public function deleteHolidayType($holiday_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                if (!$Roledata) {
                    return redirect("/")->with("error", "Unauthorized access.");
                }

                $holidayType = HolidayType::find($holiday_id);
                if (!$holidayType) {
                    return redirect("organization/holiday-type")
                        ->with("error", "Holiday Type not found.");
                }

                $holidayType->delete();

                Session::flash(
                    "message",
                    "Holiday Type Successfully Deleted."
                );
                return redirect("organization/holiday-type");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function getHolidayTypeDtl($holiday_id)
    {
        try {
            if (!empty(Session::get("emp_email"))) {
                $email = Session::get("emp_email");
                $Roledata = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();
                $data["Roledata"] = Registration::where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first();

                $data["holidaydtl"] = HolidayType::where("id", $holiday_id)
                    ->first();
                // dd($data);
                return view($this->_routePrefix . '.add-holiday-type',$data);
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            //dd("Exception caught: " . $e->getMessage());
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }

    public function holidayTypeList()
    {
        //dd('ok');
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            $holidayTypes = Holiday2Type::where('emid',$emid)->get();
           
            return view($this->_routePrefix . '.index',compact('holidayTypes'));
        } else {
            return rdirect('/');
        }
    }

    public function createHolidayType()
    {   //dd('okk');
        if (!empty(Session::get("emp_email"))) {
            return view($this->_routePrefix . '.create');
            //return view('holiday-types.create');
        } else {
            return redirect('/');
        }    
    }

    public function storeHolidayType(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
             //dd($request->all());
            $emid = Session::get("emid");
            $validated = $request->validate([
                'holiday_type_name' => 'required|string|max:100',
                'status' => 'sometimes|boolean'
            ]);
            $validated['emid']= $emid;
            //dd($validated);
            Holiday2Type::create($validated);
            Session::flash("message","Holiday Type Information Successfully Saved.");
            return redirect()->route('holiday.types.index');
        } else {
            return regirect('/');
        }                 
    }

    public function editHolidayType($id)
    {
        if (!empty(Session::get("emp_email"))) {
            $id = base64_decode($id);
            $holidayType = Holiday2Type::findOrFail($id);
            return view($this->_routePrefix . '.edit', compact('holidayType'));
            //return view('holiday-types.edit', compact('holidayType'));
        } else {
            return redirect('/');
        }
    }

    public function updateHolidayType(Request $request, $id)
    {
        if (!empty(Session::get("emp_email"))) {
            $validated = $request->validate([
                'holiday_type_name' => 'required|string|max:100',
                //'emid' => 'nullable|string|max:50',
                'status' => 'sometimes|boolean'
            ]);
            $emid = Session::get("emid");
            $validated['emid'] = $emid;
            //dd($validated);
            $holidayType = Holiday2Type::findOrFail($id);
            //dd($validated);
            $holidayType->update($validated);
            Session::flash("message","Holiday Type Information Successfully updated.");
            return redirect()->route('holiday.types.index');
        } else {
            return redirect('/');
        }
    }

    public function destroyHolidayType($id)
    {
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            $id = base64_decode($id);
            $holiday_type_id_exist = DB::table('holiday_apply')->where('holiday_type2_id',$id)->where('emid',$emid)->first();
            if($holiday_type_id_exist){
                Session::flash("error","Holiday allready apply for this holiday type !");   
                return redirect()->route('holiday.types.index');   
            }
            $holidayType = Holiday2Type::findOrFail($id);
            $holidayType->delete();
            Session::flash("message","Holiday Type Information Successfully deleted.");   
            return redirect()->route('holiday.types.index');
        } else {
            return redirect('/');
        }                 
    }

    public function toggleStatus($id)
    {
        if (!empty(Session::get("emp_email"))) {
            $holidayType = Holiday2Type::findOrFail($id);
            $holidayType->status = !$holidayType->status;
            $holidayType->save();
            Session::flash("message","Status updated successfully."); 
            return back();
        } else {
            return redirect('/');
        }
    }

    public function holidayindex()
    {
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            
            $applications = HolidayApply::with(['employee', 'holidayType'])
                ->where('emid', $emid)
                ->orderBy('apply_date', 'desc')
                ->get();
            
                return view($this->_routePrefix . '.holiday-apply-index', compact('applications'));
        } else {
            return redirect('/');
        }
    }

    public function holidaycreate()
    {
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            $holidayTypes = Holiday2Type::where('status', 1)->where('emid',$emid)->get();
            $activeEmployees = User::where('emid',$emid)->where('status','active')->get();
            return view($this->_routePrefix . '.holiday-apply-create', compact('holidayTypes','activeEmployees'));
        } else {
            return redirect('/');
        }
    }

    public function holidaystore(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            // Validate the request data
            $validated = $request->validate([
                'holiday_type2_id' => 'required|exists:holiday2types,id',
                'employee_id' => 'required|exists:users,employee_id',
                'holiday_types' => 'required|in:days,hour',
                'form_date' => 'required|date',
                'no_of_days' => 'nullable|string',
                'hour' => 'nullable|string'
            ]);
            $holidayData = [
                'employee_id' => $validated['employee_id'],
                'holiday_type2_id' => $validated['holiday_type2_id'],
                'apply_date' => now(),
                'holiday_types' => $validated['holiday_types'],
                'form_date' => $validated['form_date'],
                'emid' => $emid,
                'status' => 1,
            ];
            if ($request->holiday_types === 'days') {
                $holidayData['no_of_days'] = $validated['no_of_days'];
                $holidayData['hour'] = null;
            } else {
                $holidayData['hour'] = $validated['hour'];
                $holidayData['no_of_days'] = null;
            }
            HolidayApply::create($holidayData);
            Session::flash("message","Holiday application submitted successfully."); 
            return redirect()->route('holiday.applications.index');
        } else {
            return redirect('/');
        }                
    }

    public function holidayedit($id)
    { 
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            $application = HolidayApply::where('id', $id)
                            ->where('emid', $emid)
                            ->firstOrFail();
         
            $holidayTypes = Holiday2Type::where('status', 1)
                            ->where('emid', $emid)
                            ->get();
            
            $activeEmployees = User::where('emid', $emid)
                            ->where('status', 'active')
                            ->get();

            return view($this->_routePrefix . '.holiday-apply-edit', compact('application', 'holidayTypes', 'activeEmployees'));
            //return view('holiday-apply-edit', compact('application', 'holidayTypes', 'activeEmployees'));
        } else {
            return redirect('/');
        }
    }

    public function holidayupdate(Request $request, $id)
    {
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            
            // Validate the request data
            $validated = $request->validate([
                'holiday_type2_id' => 'required|exists:holiday2types,id',
                'employee_id' => 'required|exists:users,employee_id',
                'holiday_types' => 'required|in:days,hour',
                'form_date' => 'required|date',
                'no_of_days' => 'nullable|string',
                'hour' => 'nullable|string'
            ]);
            
            // Find the application
            $application = HolidayApply::where('id', $id)
                            ->where('emid', $emid)
                            ->firstOrFail();
            
            // Prepare update data
            $updateData = [
                'employee_id' => $validated['employee_id'],
                'holiday_type2_id' => $validated['holiday_type2_id'],
                'holiday_types' => $validated['holiday_types'],
                'form_date' => $validated['form_date'],
                'updated_at' => now(),
            ];
            
            // Set day or hour values
            if ($request->holiday_types === 'days') {
                $updateData['no_of_days'] = $validated['no_of_days'];
                $updateData['hour'] = null;
            } else {
                $updateData['hour'] = $validated['hour'];
                $updateData['no_of_days'] = null;
            }
            
            // Update the record
            $application->update($updateData);
            
            Session::flash("message", "Holiday application updated successfully."); 
            return redirect()->route('holiday.applications.index');
        } else {
            return redirect('/');
        }
    }

    public function holidaydestroy($id)
    {
        //dd($id);
        if (!empty(Session::get("emp_email"))) {
            $emid = Session::get("emid");
            
            $application = HolidayApply::where('id', $id)
                            ->where('emid', $emid)
                            ->firstOrFail();
            
            $application->delete();
            
            Session::flash("message", "Holiday application deleted successfully.");
            return redirect()->route('holiday.applications.index');
        } else {
            return redirect('/');
        }
    }





} //end class
