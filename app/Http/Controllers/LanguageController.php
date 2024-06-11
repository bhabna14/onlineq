<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageRequest;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function setLang(LanguageRequest $request)
    {
        try {
            session()->put($request->only('lang_locale'));
            return back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getLang(Request $request, $lang_name)
    {
        try {
            return view('lang.'.$lang_name);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
