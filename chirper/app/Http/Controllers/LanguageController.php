<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{



    public function lang(){
        return view('lang');
    }




    public function lang_change(Request $request){
        App::setLocale($request->lang);
        session()->put('lang',$request->lang);
        return redirect()->back();
    }








}
