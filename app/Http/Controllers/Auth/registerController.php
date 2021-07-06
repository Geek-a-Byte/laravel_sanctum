<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Auth;

class registerController extends Controller
{
    public function register(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'student_name' => 'required|string|max:255',
                'student_email' => 'required|string|email|max:255|unique:users',
                'student_id' => 'required|string|max:10|unique:users',
                'level' => 'required|integer',
                'department' => 'required|string|max:255',
                'id_card_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response([
                    'error' => $validator->errors()->all()
                ], 422);
            }

            if ($image = $request->file('id_card_photo')) {
                $cardImageSaveAsName = $request->student_id . "-card." . $image->getClientOriginalExtension();
                $upload_path = 'images/';
                $profile_image_url = $upload_path . $cardImageSaveAsName;
                $image->move($upload_path, $cardImageSaveAsName);
            }

            $request['password'] = Hash::make($request['password']);
            $request['remember_token'] = Str::random(10);
            $user = User::create([
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'student_id' => $request->student_id,
                'level' => $request->level,
                'department' => $request->department,
                'id_card_photo' => $profile_image_url,
                'password' => $request->password,
                'remember_token' => $request->remember_token,
            ]);

            return response()->json([
                'status_code' => 200,
                'message' => 'Registration Successfull',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => $error->getMessage(),
                'error' => $error,
            ]);
        }
    }
}
