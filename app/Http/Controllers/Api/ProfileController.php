<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;


class ProfileController extends Controller
{
    public function updatePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'current_password' => ['required','current_password'],
            'password' => ['required','same:password_confirmation', Rules\Password::defaults()],
            'password_confirmation' => ['required'],
        ],
        [
            'password.same' => 'The password confirmation does not match.',
        ]);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //$request->user()->update([
        //    'password' => Hash::make($validator['password']),
        //]);


        return response()->json(['status' => 'heo' ]);

    }
}
