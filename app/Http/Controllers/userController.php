<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class userController extends Controller
{
    public function userdata(Request $request)
    {
        return $request->user();
    }
  
    public function logout()
    {
        Auth::user()->token()->delete();
        return response()->json([
            'status_code' => 200,
            'message' => 'Logout successfull',
        ]);
    }
}
