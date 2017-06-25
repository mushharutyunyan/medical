<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function home(){
        return view('admin/home');
    }

    public function login(){
        return view('admin/login');
    }

    public function notFound(){
        return view('errors/404admin');
    }
}
