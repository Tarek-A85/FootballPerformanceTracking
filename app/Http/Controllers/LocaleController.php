<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $lang): RedirectResponse
    {
        session()->put('locale', $lang);

        return redirect()->back();
    }
}
