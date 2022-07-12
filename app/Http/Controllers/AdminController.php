<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
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

    public function patientProfile(Request $request) {
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
        $patients = User::where('level', 'patient')
        ->where(function($q) use ($keyword){
            $q->where('fname',"like","%$keyword%")
                ->orwhere('lname',"like","%$keyword%")
                ->orwhere('mname',"like","%$keyword%");
               
            })->get();
        return view('admin.patientprofile',[
            'data' => $patients
        ]);
    }

    public function patientStore(Request $req) {
        $patient = User::find($req->patient_id);
        $pass = $req->password ? Hash::make($req->password) : $patient->password;
        $data = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'gender' => $req->gender,
            'dob' => $req->dob,
            'civil_status' => $req->civil_status,
            'contact' => $req->contact,
            'address' => $req->address,
            'email' => $req->email,
            'username' => $req->username,
            'password' => $pass,
            'level' => 'patient'
        );
        if(!$patient) {
            User::create($data);
            Session::put("action_made","Successfully added Patient");
        } else {
            $patient->update($data);
            Session::put("action_made","Successfully updated Patient");
        }
    }

    public function patientInfo($id) {
        $patient = User::find($id);
        return json_encode($patient);
    }
    public function patientDelete($id) {
        $patient = User::find($id);
        $patient->delete();
        Session::put("delete_action","Successfully delete Patient");
    }

    public function doctorProfile(Request $request) {
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
            $q->where('fname',"like","%$keyword%")
                ->orwhere('lname',"like","%$keyword%")
                ->orwhere('mname',"like","%$keyword%");
            })->get();
        return view('admin.doctorprofile',[
            'data' => $doctors
        ]);
    }

    public function doctorStore(Request $req) {
        $patient = User::find($req->doctor_id);
        $pass = $req->password ? Hash::make($req->password) : $patient->password;
        $data = array(
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'gender' => $req->gender,
            'dob' => $req->dob,
            'civil_status' => $req->civil_status,
            'contact' => $req->contact,
            'address' => $req->address,
            'email' => $req->email,
            'username' => $req->username,
            'password' => $pass,
            'specialization' => $req->specialization,
            'level' => 'doctor'
        );
        if(!$patient) {
            User::create($data);
            Session::put("action_made","Successfully added Doctor");
        } else {
            $patient->update($data);
            Session::put("action_made","Successfully updated Doctor");
        }
    }

    public function doctorInfo($id) {
        $patient = User::find($id);
        return json_encode($patient);
    }
    public function doctorDelete($id) {
        $patient = User::find($id);
        $patient->delete();
        Session::put("delete_action","Successfully delete Doctor");
    }
}
