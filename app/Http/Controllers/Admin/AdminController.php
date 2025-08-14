<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Middleware\Admin;


class AdminController extends Controller
{
    //

     public function __construct()
    {
        $this->middleware(['auth', 'admin']); // auth + admin role
    }
    public function dashboard() {
        return view('admin.dashboard');
    }

    public function posts()  {
        return view('admin.posts');
    }
    public function comments(){
        return view('admin.comments');
    }

    public function users(){
        return view('admin.users');
    }
}
