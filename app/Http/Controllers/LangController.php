<?php

  

namespace App\Http\Controllers;

  

use Illuminate\Http\Request;

use App;

  

class LangController extends Controller

{



    public function index()

    {

        return view('lang');

    }


    public function change(Request $request)
    {
        //dd('okk');
        //App::setLocale($request->lang);

        session()->put('locale', $request->lang);

        return redirect()->back();

    }

    public function language_change(Request $request){
        //dd('okk');
        App::setLocale($request->lang);
        session()->put('locale', $request->lang);
        return redirect()->back();
    }

}