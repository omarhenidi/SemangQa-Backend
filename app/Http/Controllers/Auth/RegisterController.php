<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Exception;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function register(RegisterRequest $request)
    {
        // Manual validation
    $validator = Validator::make($request->all(), $request->rules(), $request->messages());

    // Check if validation fails
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response([
                'message' => 'Registration Successful',
                'user' => $user,
            ], 200);
        } catch (QueryException $exception) {
            // Check if the exception indicates a duplicate entry violation
            if ($exception->getCode() === '23000') {
                return response()->json(['errors' => [
                    'email' => ['The provided email address is already registered.']
                ]], 400);
            }

            return response([
                'message' => $exception->getMessage()
            ], 400);
        }
    } // End Method

}
