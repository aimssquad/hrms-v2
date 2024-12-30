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
use App\Models\HrSupportDtlDoc;
use Illuminate\Support\Facades\Storage;

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


    public function getHrSupportFile($id){
        $hrSupportFile = HrSupportFile::findOrFail($id);
        return response()->json($hrSupportFile );
    }
   

    public function deleteHrSupportFile($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                DB::beginTransaction();
                $hrSupportFile = HrSupportFile::findOrFail($id);
                HrSupportDtlDoc::where('support_id', $hrSupportFile->id)->delete();
                $data = HrSupportFile::where('id',$id)->delete();
                DB::commit();
                Session::flash('message', 'HR Support File deleted successfully.');
                return redirect()->back();
            } else {
                return redirect('superadmin');
            }
        } catch (\Exception $e) {
            DB::rollBack();
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


    public function storeOrUpdateHrSupportFile(Request $request)
    {
        // Log the incoming request for debugging
        \Log::info('Incoming Request:', $request->all());
        //dd($request->all());
        $validated = $request->validate([
            'type_id' => 'required|integer',
            'sub_type_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'smalldescription' => 'required|string',
            'file_names' => 'required|array',
            'document_desc' => 'required|array',
            'pdf_files' => 'required|array',
            'pdf_files.*' => 'file|mimes:pdf|max:2048',
            'doc_files' => 'required|array',
            'doc_files.*' => 'file|mimes:doc,docx|max:2048',
        ]);
        //dd($validated);

        DB::beginTransaction();
        try {
            // Save the main record
            $supportFile = HrSupportFile::create([
                'type_id' => $request->type_id,
                'sub_type_id' => $request->sub_type_id,
                'title' => $request->title,
                'small_description' => $request->smalldescription,
                'description' => $request->description,
                'status' => 1,
            ]);

            \Log::info('HrSupportFile created with ID: ' . $supportFile->id);

            foreach ($request->file_names as $index => $name) {
                if (isset($request->pdf_files[$index]) && isset($request->doc_files[$index]) && isset($request->document_desc[$index])) {
                    // Log the file names for debugging
                    \Log::info('File Index: ' . $index . ', Name: ' . $name);

                    $pdfPath = $request->pdf_files[$index]->store('pdfs', 'public');
                    $docPath = $request->doc_files[$index]->store('docs', 'public');

                    HrSupportDtlDoc::create([
                        'support_id' => $supportFile->id,
                        'name' => $name,
                        'document_description' => $request->document_desc[$index],
                        'pdf' => $pdfPath,
                        'doc' => $docPath,
                    ]);
                } else {
                    \Log::warning('Missing file or description for index: ' . $index);
                }
            }

            DB::commit();
            Session::flash('message', 'Record added successfully.');
            return redirect('superadmin/hr-support-files');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error adding HR Support File: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong while saving the record.');
            return redirect('superadmin/hr-support-files');
        }
    }

 
    public function editHrSupportFile($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                // Fetch the main record along with type, sub type, and related documents
                $data['user'] = HrSupportFile::with(['type', 'subType', 'hrsupportDoc'])->findOrFail($id);

                // Fetch all types for the dropdown
                $data['type'] = HrSupportFileType::all();

                // Fetch all sub types based on the selected type
                $data['subTypes'] = SubHrFileType::where('type_id', $data['user']->type_id)->get();

                return view('admin/edit-hr-file-support', $data);
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }


    public function updateHrSupportFile(Request $request, $id)
    {
        $validated = $request->validate([
            'type_id' => 'required|integer',
            'sub_type_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'required|string',
            'smalldescription' => 'required|string',
            'file_names' => 'required|array',
            'document_desc' => 'required|array',
            'pdf_files.*' => 'nullable|file|mimes:pdf|max:2048',
            'doc_files.*' => 'nullable|file|mimes:doc,docx|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Update main record
            $supportFile = HrSupportFile::findOrFail($id);
            $supportFile->update([
                'type_id' => $validated['type_id'],
                'sub_type_id' => $validated['sub_type_id'],
                'title' => $validated['title'],
                'small_description' => $validated['smalldescription'],
                'description' => $validated['description'],
            ]);

            // Handle file updates and new uploads
            if ($request->has('removed_files')) {
                HrSupportDtlDoc::whereIn('id', $request->removed_files)->delete();
            }

            foreach ($request->file_names as $index => $name) {
                $docId = $request->doc_ids[$index] ?? null;
                $pdfPath = $request->pdf_files[$index] ?? null;
                $docPath = $request->doc_files[$index] ?? null;

                if ($docId) {
                    // Update existing document
                    $doc = HrSupportDtlDoc::find($docId);
                    $doc->update([
                        'name' => $name,
                        'document_description' => $validated['document_desc'][$index],
                        'pdf' => $pdfPath ? $pdfPath->store('pdfs', 'public') : $doc->pdf,
                        'doc' => $docPath ? $docPath->store('docs', 'public') : $doc->doc,
                    ]);
                } else {
                    // Add new document
                    HrSupportDtlDoc::create([
                        'support_id' => $supportFile->id,
                        'name' => $name,
                        'document_description' => $validated['document_desc'][$index],
                        'pdf' => $pdfPath ? $pdfPath->store('pdfs', 'public') : null,
                        'doc' => $docPath ? $docPath->store('docs', 'public') : null,
                    ]);
                }
            }

            DB::commit();
            Session::flash('message', 'Record update successfully.');
            return redirect('superadmin/hr-support-files');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating HR Support File:', ['message' => $e->getMessage()]);
            Session::flash('message', 'Record update successfully.');
            return back();
        }
    }





    public function deleteDynamicHrFile(Request $request)
    {
        $docId = $request->id;
        try {
            $document = HrSupportDtlDoc::findOrFail($docId);
            // Delete the PDF file if it exists
            if ($document->pdf && Storage::disk('public')->exists($document->pdf)) {
                Storage::disk('public')->delete($document->pdf);
            }
            // Delete the DOC file if it exists
            if ($document->doc && Storage::disk('public')->exists($document->doc)) {
                Storage::disk('public')->delete($document->doc);
            }
            // Delete the record from the database
            $document->delete();
            return response()->json(['success' => true, 'message' => 'Document and associated files deleted successfully.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete the document.']);
        }
    }



    


}
