<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\PatientSched;
use App\DoctorSched;
use App\User;
class PatientController extends Controller
{
    public function __construct()
    {
        if($login = Session::get('auth')){
            $this->middleware('auth');
        }
    }

    public function index()
    {
        return view('patients.home');
    }

    public function schedulePatient(Request $request) {
        $user = Session::get('auth');
        if($request->view_all == 'view_all')
            $keyword = '';
        else{
            if(Session::get("keyword")){
                if(!empty($request->keyword) && Session::get("keyword") != $request->keyword)
                    $keyword = $request->keyword;
                else
                    $keyword = Session::get("keyword");
            } else {
                $keyword = $request->keyword;
            }
        }
        Session::put('keyword',$keyword);
        $doctors = User::where('level', 'doctor')
        ->where(function($q) use ($keyword){
            $q->where('specialization',"like","%$keyword%");
            })->get();
        $myschedules = PatientSched::where('patient_id', $user->id)->get();
        return view('patients.schedpat',[
            'data' => $doctors,
            'myscheds' => $myschedules
        ]);
    }
}
