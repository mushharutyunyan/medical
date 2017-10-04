<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Tiket;
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

    public function tickets(){
        $tickets = Tiket::all();
        return view('admin.tickets',['tickets' => $tickets]);
    }
}
