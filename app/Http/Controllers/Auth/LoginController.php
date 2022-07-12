<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function index()
    {
        if($login = Session::get('auth')){
            return redirect($login->level);
        }else{
            Session::flush();
            return view('auth.login');
        }
    }

    public function login(Request $req)
    {
        $login = User::where('username',$req->username)
            ->first();
        if($login)
        {
            if(Hash::check($req->password,$login->password))
            {
                Session::put('auth',$login);
                if($login->level=='admin')
                    return redirect('admin');
                else if($login->level=='doctor')
                    return redirect('doctor');
                else if($login->level=='patient')
                    return redirect('patient');
                else{
                    Session::forget('auth');
                      return Redirect::back()->withErrors(['msg' => 'You don\'t have access in this system.']);
                }
            }
            else{
                return Redirect::back()->withErrors(['msg' => 'These credentials do not match our records.']);
            }
        }
        else{
            return Redirect::back()->withErrors(['msg' => 'These credentials do not match our records.']);
        }
    }

    public function registerIndex()
    {
        return view('auth.register');
    }

    public function register(Request $req)
    {
        $data = array(
            'level' => $req->level,
            'fname' => $req->fname,
            'mname' => $req->mname,
            'lname' => $req->lname,
            'email' => $req->email, 
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'is_accept' => 0
        );
        User::create($data);
    }
}
