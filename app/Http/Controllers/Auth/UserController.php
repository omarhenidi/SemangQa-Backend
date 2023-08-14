<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            return response()->json(['status' => true,'message' => "Successfully User",'data' => $user], 200);

        } else {
            return response()->json(['status' => false,'message' => 'Faild To Get User'],500);
        }

    }

}
