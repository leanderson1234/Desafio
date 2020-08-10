<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
   public function login(){
    
    return view('admin.login_auth.index');
   }
   public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
      
        if (Auth::guard('admin')->attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('client.index');
        }
    }
    public function logout(){
        Auth::logout();
    }
    
}
