<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
  //
  public function __construct(){
    $this->middleware('guest:admin');
  }

  public function showLoginForm(){
    return view('auth.admin-login');
  }

  public function login(Request $request){

    //Validate the form data
    $this->validate($request, [
      'email'=>'required|email',
      'password'=>'required|min:6'
    ]);

    //Attempt to log user in
    //if success, redirerct to admin dashboard
    //dd($request->all());
    if(Auth::guard('admin')->attempt(array(
      'email'=>$request->email,
      'password'=>$request->password
    ), $request->remember)){
      return redirect()->intended(route('admin.home'));
    }
    //if failed redirect to admin login
    return redirect()->route('admin.login');
    //return redirect()->withInput($request->only('email', 'remember'));
  }
}
