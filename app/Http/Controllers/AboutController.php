<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Afficher la page "À Propos".
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('about');
    }
}
