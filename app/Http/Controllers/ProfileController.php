<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    /**
     * Summary of index
     *Profile Page
     * @return \Illuminate\Contracts\View\View
     */
    public function index()  {
        return view('profile');
    }
}
