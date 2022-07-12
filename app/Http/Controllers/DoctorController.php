<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Medicine;
use App\DoctorSched;
class DoctorController extends Controller
{
    public function __construct()
    {
        if($login = Session::get('auth')){
            $this->middleware('auth');
        }
    }

    public function index()
    {
        return view('doctors.home');
    }

    public function medicineProfile(Request $request) {
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
        $medicine = Medicine::where('doctor_id', $user->id)
        ->where(function($q) use ($keyword){
            $q->where('name',"like","%$keyword%");
               
            })->get();
        return view('doctors.medicine',[
            'data' => $medicine
        ]);
    }

    public function medicineStore(Request $req) {
        $user = Session::get('auth');
        $medicine = Medicine::find($req->medicine_id);
        $data = array(
            'doctor_id' => $user->id,
            'name' => $req->name,
            'price' => $req->price,
            'exp_date' => $req->exp_date
        );
        if(!$medicine) {
            Medicine::create($data);
            Session::put("action_made","Successfully added Medicine");
        } else {
            $medicine->update($data);
            Session::put("action_made","Successfully updated Medicine");
        }
    }

    public function medicineInfo($id) {
        $medicine = Medicine::find($id);
        return json_encode($medicine);
    }

    public function medicineDelete($id) {
        $med = Medicine::find($id);
        $med->delete();
        Session::put("delete_action","Successfully delete medicine");
    }

    public function myschedProfile(Request $request) {
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
        $medicine = DoctorSched::where('doctor_id', $user->id)
        ->where(function($q) use ($keyword){
            $q->where('schedule_date',"like","%$keyword%");
               
            })->get();
        return view('doctors.schedule',[
            'data' => $medicine
        ]);
    }

    public function myschedStore(Request $req) {
        $user = Session::get('auth');
        $medicine = DoctorSched::find($req->myschedule_id);
        $data = array(
            'doctor_id' => $user->id,
            'schedule_date' => $req->schedule_date,
            'start_time' => $req->start_time,
            'end_time' => $req->end_time,
            'appointment_fee' => $req->appointment_fee,
            'status' => 'not booked'
        );
        if(!$medicine) {
            DoctorSched::create($data);
            Session::put("action_made","Successfully added schedule");
        } else {
            $medicine->update($data);
            Session::put("action_made","Successfully updated schedule");
        }
    }

    public function myschedInfo($id) {
        $medicine = DoctorSched::find($id);
        return json_encode($medicine);
    }

    public function myschedDelete($id) {
        $med = DoctorSched::find($id);
        $med->delete();
        Session::put("delete_action","Successfully delete schedule");
    }
}
