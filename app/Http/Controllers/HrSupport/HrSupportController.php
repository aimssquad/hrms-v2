<?php

namespace App\Http\Controllers\HrSupport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Exception;
use File;
use Session;
use Validator;
use App\Models\HrSupport\HrSupportFileType;
use App\Models\HrSupport\HrSupportFile;
use App\Models\HrSupport\SubHrFileType;

class HrSupportController extends Controller
{
    public function hrSupportFiletype(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {

                $data['data'] = HrSupportFileType::all();
                return View('admin/hr-file-support-type', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function addHrSupportFile(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                return View('admin/add-hr-file-support-type');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function storeOrUpdateHrSupportFileType(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $rules = [
                    'type' => 'required|string|max:255',
                    'status' => 'required|in:0,1',
                    'description' => 'required|string',
                ];

                // Custom error messages
                $messages = [
                    'status.in' => 'The status field must be either 0 or 1.',
                ];

                // Validate the request
                $request->validate($rules, $messages);

                // Check if the type already exists
                if ($request->has('id')) {
                    $existingFileType = HrSupportFileType::where('type', $request->type)->where('id', '!=', $request->id)->first();
                } else {
                    $existingFileType = HrSupportFileType::where('type', $request->type)->first();
                }

                if ($existingFileType) {
                    Session::flash('error', 'The type already exists.');
                    return redirect()->back();
                }

                // If editing, find the existing record by ID
                if ($request->has('id')) {
                    $hrSupportFileType = HrSupportFileType::findOrFail($request->id);
                } else { // If adding, create a new instance
                    $hrSupportFileType = new HrSupportFileType;
                }

                // Assign request data to the model
                $hrSupportFileType->type = $request->type;
                $hrSupportFileType->status = $request->status;
                $hrSupportFileType->description = $request->description;

                // Save the model
                $hrSupportFileType->save();

                // Redirect back with success message
                Session::flash('message', 'Hr Support File System ' . ($request->has('id') ? 'updated' : 'added') . ' successfully.');
                return redirect('superadmin/hr-support-file-type');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function editHrSupportFileType($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $user = HrSupportFileType::findOrFail($id);
                return view('admin/add-hr-file-support-type')->with('user', $user);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function deleteHrSupportFileType($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $hrSupportFileType = HrSupportFileType::findOrFail($id);
                $hrSupportFileType->delete();
                Session::flash('message', 'HR Support File Type deleted successfully.');
                return redirect()->back();
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function getHrSupportFileType($id)
    {
        $hrSupportFileType = HrSupportFileType::findOrFail($id);
        return response()->json($hrSupportFileType);
    }
    public function hrSupportFile(Request $request)
    {

        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                //$data['data'] = HrSupportFile::with('type')->get();
                $data['data'] = HrSupportFile::with(['type', 'subType'])->get();
                // dd($data);
                return View('admin/hr-support-file', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function addHrSupport(Request $request){
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $data['type'] = HrSupportFileType::all();
                return View('admin/add-hr-file-support',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    // public function editHrSupportFile($id)
    // {
    //     try {
    //         $email = Session::get('empsu_email');
    //         if (!empty($email)) {
    //             $data['user'] = HrSupportFile::with('type')->findOrFail($id);
    //             $data['type'] = HrSupportFileType::all();
    //             //dd($data['type']);
    //             return view('admin/add-hr-file-support',$data);
    //         } else {
    //             return redirect('superadmin');
    //         }
    //     } catch (Exception $e) {
    //         throw new \App\Exceptions\AdminException($e->getMessage());
    //     }
    // }
    public function editHrSupportFile($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                // Fetch the main record along with type and sub type
                $data['user'] = HrSupportFile::with(['type', 'subType'])->findOrFail($id);

                // Fetch all types for the dropdown
                $data['type'] = HrSupportFileType::all();

                // Fetch all sub types based on the selected type
                $data['subTypes'] = SubHrFileType::where('type_id', $data['user']->type_id)->get();

                return view('admin/add-hr-file-support', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function storeOrUpdateHrSupportFile(Request $request)
    {
        //dd($request->all());
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                // If editing an existing record, find the record by ID
                if ($request->has('id')) {
                    $hrSupportFile = HrSupportFile::findOrFail($request->id);
                } else {
                    // If creating a new record, create a new instance
                    $hrSupportFile = new HrSupportFile;
                }

                // Update or set the attributes
                $hrSupportFile->type_id = $request->input('type_id');
                $hrSupportFile->sub_type_id = $request->input('sub_type_id');
                $hrSupportFile->title = $request->input('title');
                $hrSupportFile->description = $request->input('description');
                $hrSupportFile->small_description = $request->input('smalldescription');
                $hrSupportFile->status = $request->input('status', 'active');

                // Handle file uploads
                if ($request->hasFile('pdf')) {
                    $pdfFileName = $request->file('pdf')->getClientOriginalName();
                    $request->file('pdf')->storeAs('public/hrsupport/pdf', $pdfFileName);
                    $hrSupportFile->pdf = $pdfFileName;
                }

                if ($request->hasFile('doc')) {
                    $docFileName = $request->file('doc')->getClientOriginalName();
                    $request->file('doc')->storeAs('public/hrsupport/doc', $docFileName);
                    $hrSupportFile->doc = $docFileName;
                }
                //dd($hrSupportFile);
                // Save the record
                $hrSupportFile->save();

                // Redirect back with success message
                Session::flash('message', 'Hr Support File ' . (isset($request->id) ? 'updated' : 'added') . ' successfully.');
                return redirect('superadmin/hr-support-files');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function getHrSupportFile($id){
        $hrSupportFile = HrSupportFile::findOrFail($id);
        return response()->json($hrSupportFile );
    }
    public function deleteHrSupportFile($id){
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $hrSupportFile = HrSupportFile::findOrFail($id);
                $hrSupportFile->delete();
                Session::flash('message', 'HR Support File deleted successfully.');
                return redirect()->back();
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function viewdashboard(Request $request){
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['data'] = HrSupportFileType::all();
            return View('hrsupport/dashboard', $data);
        } else {
            return redirect('/');
        }

    }
    public function supportFile($id){
        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
                $data['data'] = HrSupportFile::with('type')->where('type_id', $id)->get();
                //dd($data['data']);
            return View('hrsupport/support-file-list', $data);
        } else {
            return redirect('/');
        }
    }
    public function supportFileDetails($id){

        $email = Session::get('emp_email');
        if (!empty($email)) {

            $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
                $data['data'] = HrSupportFile::with('type')->where('id', $id)->first();
                $typeId =  $data['data']->type_id;
                $data['relatedFiles'] = HrSupportFile::with('type')
                                      ->where('type_id', $typeId)
                                      ->where('id', '!=', $id)
                                      ->get();
                 //dd($data['relatedFiles']);
                return View('hrsupport/support-file-details', $data);
        } else {
            return redirect('/');
        }

    }

    public function addSubHrSupportFileList(Request $request)
    {
        $email = Session::get('empsu_email');
        if (!empty($email)) {
            // Eager load the 'type' relationship
            $data['data'] = SubHrFileType::with('type')->get();
            
            return view('admin.sub-type-list', $data);
        } else {
            return redirect('superadmin');
        }
    }

    public function addSubHrSupportFile(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $data['type'] = DB::table('hr_support_file_types')->get();
                return View('admin/add-sub-hr-file-support-type',$data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    public function store(Request $request)
    {
        //dd($request->all());
        // Validate input fields
        $valoDated = $request->validate([
            'type_id' => 'required|integer',
            'sub_name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
        //dd($valoDated);
        $subHrFileType = new SubHrFileType();
        $subHrFileType->type_id = $request->type_id;
        $subHrFileType->sub_name = $request->sub_name;
        $subHrFileType->status = $request->status;
        //$subHrFileType->description = $request->description;

        // Save the record
        if ($subHrFileType->save()) {
            Session::flash('message', 'Record added successfully.');
            return redirect('superadmin/sub/add-hr-support-file-type-List');
        }
        Session::flash('error', 'Failed to save the record');
        return redirect('superadmin/sub/add-hr-support-file-type-List');
    }

    //---------------ajax call----------
    public function getSubTypes(Request $request)
    {
        $typeId = $request->type_id;

        // Fetch subtypes based on the provided type_id
        $subTypes = SubHrFileType::where('type_id', $typeId)->get(['id', 'sub_name']);

        if ($subTypes->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No subtypes found.']);
        }

        return response()->json(['success' => true, 'subTypes' => $subTypes]);
    }

    public function editSubHrSupportFileType($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $user = SubHrFileType::join('hr_support_file_types', 'hr_support_file_types.id', '=', 'sub_hr_filetype.type_id')
                    ->where('sub_hr_filetype.id', $id)
                    ->select('sub_hr_filetype.*')
                    ->first();
                $type = HrSupportFileType::all();
                if ($user) {
                    return view('admin.edit_sub_hr_support_file_type', compact('user', 'type'));
                } else {
                    return redirect('superadmin')->with('error', 'User not found');
                }
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function updateSubHrSupportFileType(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                // Validate the incoming data
                $validated = $request->validate([
                    'type_id' => 'required|exists:hr_support_file_types,id',
                    'sub_name' => 'required|string|max:255',
                    'status' => 'required|boolean', 
                ]);

                // Find the record to update
                $user = SubHrFileType::findOrFail($request->id);

                // Update the fields
                $user->type_id = $request->type_id;
                $user->sub_name = $request->sub_name;
                $user->status = $request->status;

                // Save the updated record
                $user->save();

                // Redirect or return a success response
                return redirect('superadmin/sub/add-hr-support-file-type-List');
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            // Handle any exceptions or errors
            return redirect('superadmin')->with('error', $e->getMessage());
        }
    }

    


}
