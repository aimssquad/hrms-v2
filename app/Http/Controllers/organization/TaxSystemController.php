<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\TaxSystem;
use Illuminate\Http\Request;

class TaxSystemController extends Controller
{
    public function index()
    {
        $taxSystems = TaxSystem::orderBy('name')->get();
        return view('employeer.tax-systems.index', compact('taxSystems'));
    }

    public function create()
    {
        return view('employeer.tax-systems.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:50',
            'country_code' => 'required|string|max:5',
        ]);

        TaxSystem::create([
            'name'         => $request->name,
            'country_code' => strtoupper($request->country_code),
            'is_multi_stage' => $request->is_multi_stage ?? 0,
        ]);

        return redirect()
            ->route('org.taxsystem.list')
            ->with('success', 'Tax system added successfully');
    }

    public function edit($id)
    {
        $id = base64_decode($id);
        $taxSystem = TaxSystem::findOrFail($id);

        return view('employeer.tax-systems.edit', compact('taxSystem'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|string|max:50',
            'country_code' => 'required|string|max:5',
        ]);

        $taxSystem = TaxSystem::findOrFail($id);

        $taxSystem->update([
            'name'          => $request->name,
            'country_code'  => strtoupper($request->country_code),
            'is_multi_stage'=> $request->is_multi_stage ?? 0,
        ]);

        return redirect()
            ->route('org.taxsystem.list')
            ->with('success', 'Tax system updated successfully');
    }

    public function destroy($id)
    {
        $taxSystem = TaxSystem::findOrFail($id);
        $taxSystem->delete();

        return redirect()->back()->with('success', 'Tax system deleted');
    }
}
