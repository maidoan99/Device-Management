<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class LangController extends Controller
{

    public function setLang(Request $request)
      {
          session(['locale' => $request->locale]);
          return redirect()->back();
      }
}
