<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;
use App\Models\Dossier2;
use App\Models\Dossier3;
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

        // Fetch Dossier2 records where the dossier_id matches the selected Dossier
        $dossiers2 = Dossier2::where('dossier_id', $dossierId)->get();

        // Return the Dossier2 records as a JSON response
        return response()->json(['dossiers2' => $dossiers2]);
    }   

    public function dossier3Save(Request $request)
    {
        //dd($request->all());
        $validatedData = $request->validate([
            'dossier_id'   => 'required|exists:dossier,id',   // Ensure dossier_id exists in the 'dossier' table
            'dossier_id2'  => 'required|exists:dossier2,id',  // Ensure dossier_id2 exists in the 'dossier2' table
            'title3'       => 'required|string|max:255',      // Validate title2
            'link3'        => 'required|url',                  // Validate link2 (URL format)
            'dossier_file3'=> 'nullable|file|mimes:pdf,jpeg,png,jpg,gif|max:3072', // Max 3MB file size
        ]);
        //dd($validatedData);
        // Handle file upload if it exists
        $filePath = null;
        if ($request->hasFile('dossier_file3')) {
            // Store the uploaded file in the 'dossiers2' folder in storage
            $filePath = $request->file('dossier_file3')->store('dossiers3', 'public');
        }

        // Save the data to the Dossier2 table
        Dossier3::create([
            'dossier_id'   => $validatedData['dossier_id'],
            'dossier2_id'  => $validatedData['dossier_id2'],
            'title3'       => $validatedData['title3'],
            'link3'        => $validatedData['link3'],
            'dossier_file3'=> $filePath, // Store the file path if a file is uploaded
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Dossier2 added successfully!');
    }

    public function editDossir3($id)
    {
        $dossier3 = \App\Models\Dossier3::findOrFail($id);
        $dossiers = \App\Models\Dossier::all();
        $dossier2s = \App\Models\Dossier2::all();
        
        return view('admin/dossier/edit-dossir', compact('dossier3', 'dossiers', 'dossier2s'));
    }
    







} // End class
