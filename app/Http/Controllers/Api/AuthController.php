<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{
    public function signUp (Request $request) {
        return json_encode('dfdf');
    }

    public function signIn ($email,$password) {

    }
}
