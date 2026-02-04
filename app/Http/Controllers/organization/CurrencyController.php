<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('employeer.guest-bills.index', compact('currencies'));
    }

    public function create()
    {
        //dd('okk');
        return view('employeer.guest-bills.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'code' => 'required|string|max:10',
            'symbol' => 'required|string|max:10',
        ]);

        Currency::create($request->all());

        return redirect()->route('org.currency.list')
            ->with('success', 'Currency added successfully');
    }

    public function edit($id)
    {
        //dd($id);
        $id = base64_decode($id);
        //dd($id);
        $currencies = Currency::find($id);
        return view('employeer.guest-bills.edit', compact('currencies'));
    }

    public function update(Request $request, $id)
    {
        //dd('okk');
        $request->validate([
            'code'   => 'required|string|max:10',
            'symbol' => 'required|string|max:10',
            'is_active' => 'required|in:0,1',
        ]);

        $currency = Currency::findOrFail($id);

        $currency->update([
            'code'      => $request->code,
            'symbol'    => $request->symbol,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('org.currency.list')
            ->with('success', 'Currency updated successfully');
    }


    public function destroy($id)
    {
        //dd('okk');
        $currency = Currency::findOrFail($id);
        $currency->delete();

        return redirect()
            ->back()
            ->with('success', 'Currency deleted');
    }

}
