<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;
use App\Models\Dossier2;
use App\Models\Dossier3;
use App\Models\DossierFile;
use Session;
use Validator;

class DossierController extends Controller
{
    public function sponsorDossierList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $dossiers = Dossier::all();
            return view('admin/dossier/sponsor-dossier-list', compact('dossiers'));
        } else {
            redirect('superadmin');
        }
    }

    public function sponsorDossierAdd(Request $request){
        $email = Session::get('empsu_email');
        //dd('okk');
        if(!empty($email)){
            return view('admin/dossier/sponsor-dossier-add');
        } else {
            redirect('superadmin');
        }
    }

    // Add a new dossier
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'dossier_file' => 'required|file|mimes:pdf,jpeg,png,jpg,gif|max:3072', // 3MB max
        ]);
        $filePath = $request->file('dossier_file')->store('superadmin-dossier', 'public');
        Dossier::create([
            'title' => $request->title,
            'link' => $request->link,
            'dossier_file' => $filePath, // Store the path in the database
        ]);

        Session::flash('message', 'Sponsor Dossier add successfully .');
        return redirect('superadmin/sponsor-dossier-list');
    }


    // Show edit form
    public function edit($id)
    {
        $dossier = Dossier::findOrFail($id);
        return view('admin.dossier.edit', compact('dossier'));
    }

    // Update dossier
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'dossier_file' => 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:3072', // Allow optional file upload
        ]);
        $dossier = Dossier::findOrFail($id);
        $data = $request->only(['title', 'link']);
        if ($request->hasFile('dossier_file')) {
            $filePath = $request->file('dossier_file')->store('superadmin-dossier', 'public');

            // Delete the old file if it exists
            if ($dossier->dossier_file && \Storage::disk('public')->exists($dossier->dossier_file)) {
                \Storage::disk('public')->delete($dossier->dossier_file);
            }
            $data['dossier_file'] = $filePath;
        }
        $dossier->update($data);
        Session::flash('message', 'Sponsor Dossier updated successfully .');
        return redirect('superadmin/sponsor-dossier-list');
    }
    //Delete Dossier
    public function destroy($id)
    {
        $dossier = Dossier::findOrFail($id);

        if ($dossier->dossier_file && \Storage::disk('public')->exists($dossier->dossier_file)) {
            \Storage::disk('public')->delete($dossier->dossier_file);
        }
        $dossier->delete();
        Session::flash('message', 'Sponsor Dossier Delete successfully .');
        return redirect('superadmin/sponsor-dossier-list');
    }

    public function index()
    {
        $dossiers2 = Dossier2::with('dossier')->get(); // Assuming a relation to the Dossier table
        return view('admin/dossier/dossier2-list', compact('dossiers2'));
    }

    public function dossir2(Request $request){ 
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $dossiers = Dossier::all();
            return view('admin/dossier/dossier2', compact('dossiers'));
        } else {
            redirect('superadmin');
        }
    }
    

    public function dossier2Save(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'dossier_id'   => 'required|exists:dossier,id', // Check if dossier_id exists in the dossier table
            'title2'       => 'required|string|max:255',
            'link2'        => 'required|url',
            'dossier_file2'=> 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:3072', // Max 3 MB
        ]);
    
        // Handle file upload
        $filePath = null;
        if ($request->hasFile('dossier_file2')) {
            $filePath = $request->file('dossier_file2')->store('dossiers2', 'public');
        }
    
        // Save data to the database
        Dossier2::create([
            'dossier_id'   => $validatedData['dossier_id'],
            'title2'       => $validatedData['title2'],
            'link2'        => $validatedData['link2'],
            'dossier_file2'=> $filePath,
        ]);
    
        Session::flash('message', 'Sponsor Dossier Add successfully .');
        return redirect('superadmin/dossiers2');
    }

    public function editDossier2($id)
    {
        $dossier2 = Dossier2::findOrFail($id);
        $dossiers = Dossier::all(); // Assuming this is needed for the dropdown
        return view('admin/dossier/edit_dossier2', compact('dossier2', 'dossiers'));
    }

    public function updateDossier2(Request $request, $id)
    {
        $dossier2 = Dossier2::findOrFail($id);

        $request->validate([
            'dossier_id'   => 'required|exists:dossier,id',
            'title2'       => 'required|string|max:255',
            'link2'        => 'required|url',
            'dossier_file2'=> 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:3072',
        ]);

        $data = $request->only(['dossier_id', 'title2', 'link2']);

        if ($request->hasFile('dossier_file2')) {
            $filePath = $request->file('dossier_file2')->store('dossiers2', 'public');

            // Delete old file
            if ($dossier2->dossier_file2 && file_exists(storage_path('app/public/' . $dossier2->dossier_file2))) {
                unlink(storage_path('app/public/' . $dossier2->dossier_file2));
            }

            $data['dossier_file2'] = $filePath;
        }

        $dossier2->update($data);
        Session::flash('message', 'Sponsor Dossier Updated successfully .');
        return redirect('superadmin/dossiers2');
    }

    //------------------------------------ Dossier3 -------------------------------------
    public function dossier3List()
    {
        $dossier3Records = \App\Models\Dossier3::with(['dossier', 'dossier2'])->get(); // Assuming relationships
        //dd($dossier3Records);
        return view('admin/dossier/dossier3-list', compact('dossier3Records'));
    }

    public function dossier3view (Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $dossiers = Dossier::all();
            return view('admin/dossier/dossier3',compact('dossiers'));
            //return view('admin/dossier/dossier2', compact('dossiers'));
        } else {
            redirect('superadmin');
        }
        
    }

    public function getDossier2ByDossier(Request $request)
    {
        $dossierId = $request->get('dossier_id');
        $dossiers2 = Dossier2::where('dossier_id', $dossierId)->get();
        return response()->json(['dossiers2' => $dossiers2]);
    }   

  

   
    public function editDossier3($id)
    {
        $dossier3 = \App\Models\Dossier3::with('files')->findOrFail($id);
        $dossiers = \App\Models\Dossier::all();
        $dossier2s = \App\Models\Dossier2::all();
        //dd($dossier2s);
        return view('admin/dossier/edit-dossier3', compact('dossier3', 'dossiers', 'dossier2s'));
    }

    public function dossier3Save(Request $request)
    {
        //dd($request->all());
        $data = $request->validate([
            'dossier_id' => 'required|integer|exists:dossier,id', // Ensure dossier_id exists in the dossiers table
            'dossier_id2' => 'required|string',
            'title3' => 'required|string|max:255',
            'file_name' => 'nullable|array', // Validate `file_name` as an array
            'file_name.*' => 'nullable|string|max:255', // Validate each `file_name` item
            'description' => 'nullable|array', // Validate `description` as an array
            'description.*' => 'nullable|string', // Validate each `description` item
            'file' => 'nullable|array', // Validate `file` as an array
            'file.*' => 'nullable|file|max:2048', // Validate each file with a max size of 2MB
        ]);
        //dd($data);
        // Save data in the `dossier3` table
        $dossier3 = new Dossier3();
        $dossier3->dossier_id = $request->dossier_id; // Foreign key for the dossier3 table
        $dossier3->dossier2_id = $request->dossier_id2;
        $dossier3->title3 = $request->title3;
        $dossier3->save();

        // Save dynamic rows in the `dossier_file` table
        if ($request->has('file_name')) {
            foreach ($request->file_name as $index => $fileName) {
                $dossierFile = new DossierFile();
                $dossierFile->dossier_id = $dossier3->id; // Link the files to the newly created dossier3 record
                $dossierFile->file_name = $fileName;
                $dossierFile->description = $request->description[$index] ?? null;

                // Handle file upload
                if ($request->hasFile("file.$index")) {
                    $file = $request->file("file.$index");
                    $filePath = $file->store('uploads/dossier_files', 'public'); // Save to storage/app/public/uploads/dossier_files
                    $dossierFile->file = $filePath;
                }

                $dossierFile->save();
            }
        }

        // Redirect with success message
        return redirect()->back()->with('success', 'Dossier saved successfully!');
    }

    // public function updateDossier3(Request $request, $id)
    // {
    //     //dd($request->all());
    //     // Validate incoming request data
    //     $data = $request->validate([
    //         'dossier_id' => 'required|integer',
    //         'dossier_id2' => 'required|integer',
    //         'title3' => 'required|string',
    //         'file_name.*' => 'nullable|string',
    //         'description.*' => 'nullable|string',
    //         'file.*' => 'nullable|file|max:2048', // 2MB file size limit
    //     ]);

    //     // Find the Dossier3 record
    //     $dossier3 = \App\Models\Dossier3::findOrFail($id);

    //     // Update main Dossier3 fields
    //     $dossier3->dossier_id = $data['dossier_id'];
    //     $dossier3->dossier2_id = $data['dossier_id2'];
    //     $dossier3->title3 = $data['title3'];
    //     $dossier3->save();

    //     // Handle dossier files
    //     if ($request->has('file_name')) {
    //         foreach ($data['file_name'] as $index => $fileName) {
    //             $fileId = $request->file_id[$index] ?? null; // Assume there's a hidden input for file_id
    //             $fileRecord = \App\Models\DossierFile::find($fileId);

    //             if ($fileRecord) {
    //                 // Update existing file record
    //                 $fileRecord->file_name = $fileName;
    //                 $fileRecord->description = $data['description'][$index] ?? '';

    //                 // Handle file upload if a new file is provided
    //                 if ($request->hasFile("file.$index")) {
    //                     $uploadedFile = $request->file("file.$index");
    //                     $filePath = $uploadedFile->store('dossier_files', 'public');
    //                     $fileRecord->file = $filePath;
    //                 }

    //                 $fileRecord->save();
    //             } else {
    //                 // Create a new file record if the file_id is not found
    //                 $newFilePath = $request->file('file')[$index]->store('dossier_files', 'public') ?? null;

    //                 \App\Models\DossierFile::create([
    //                     'dossier3_id' => $dossier3->id,
    //                     'file_name' => $fileName,
    //                     'description' => $data['description'][$index] ?? '',
    //                     'file' => $newFilePath,
    //                 ]);
    //             }
    //         }
    //     }

    //     return redirect()->back()->with('success', 'Dossier3 updated successfully.');
    // }

    public function updateDossier3(Request $request, $id)
    {
        //dd($request->all());
        try {
            // Find the Dossier3 record
            $dossier3 = \App\Models\Dossier3::findOrFail($id);

            // Update main Dossier3 fields
            $dossier3->dossier_id = $request->dossier_id;
            $dossier3->dossier2_id = $request->dossier_id2;
            $dossier3->title3 = $request->title3;
            $dossier3->save();

            // Handle dossier files
            if ($request->has('file_name')) {
                //dd($dossier3->id);
                foreach ($request->file_name as $index => $fileName) {
                    $fileRecord = \App\Models\DossierFile::firstOrNew([
                        'dossier_id' => $dossier3->id,
                        'file_name' => $fileName,
                    ]);
                    //dd($fileRecord);
                    // Update file description
                    $fileRecord->description = $request->description[$index] ?? '';

                    // Handle file upload if provided
                    if (isset($request->file('file')[$index])) {
                        $fileRecord->file = $request->file('file')[$index]->store('uploads/dossier_files', 'public');
                    }

                    $fileRecord->save();
                }
            }

            // Success message and redirect
            Session::flash('message', 'Dossier3 updated successfully.');
            return redirect()->back();

        } catch (\Exception $e) {
            // Log error and show failure message
            \Log::error('Error updating Dossier3: ' . $e->getMessage());
            Session::flash('error', 'Something went wrong. Please try again.');
            return redirect()->back();
        }
    }


    







} // End class
