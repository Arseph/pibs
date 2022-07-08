<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
class AdminController extends Controller
{
    public function __construct()
    {
        if($login = Session::get('auth')){
            $this->middleware('auth');
        }
    }

    public function index()
    {
        return view('admin.home');
    }
}
