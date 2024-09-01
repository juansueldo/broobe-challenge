<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguagueController extends Controller
{
    public function switchLang($locale)
    {
        if (array_key_exists($locale, config('app.locales'))) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        }
        return Redirect::back();
    }
}
