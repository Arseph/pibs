<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\User;
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

    public function patientProfile() {
        $patients = User::where('level', 'patient')->get();
        return view('admin.patientprofile',[
            'data' => $patients
        ]);
    }
}
