<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function signUp (Request $req) {
        $result = json_decode($req->getContent());
        $response = [];


        $existUser = User::where('email',$result->email)->first();
        if($existUser !== null){
            $response['error'] = 'user exist';
        }else{
            $user = [];
            $user['email'] = $result->email;
            $user['name'] = $result->name;
            $user['password'] = Hash::make($result->password);

            if(User::create($user)){
                $response['status'] = 'success';
            }else{
                $response['status'] = 'error'; 
            }
        }

        return response()->json($response);
    }

    public function signIn (Request $req) {
        $result = json_decode($req->getContent());
        $response = [];

        $user = User::where('email',$result->email)->first();
        if($user === null){
            $response['error'] = 'user is no found';
        }else{
            if(Hash::check($result->password,$user->password)){
                $response['status'] = 'success';
            }else{
                $response['error'] = 'uncorect password';
            }

        }


        return response()->json($response);
    }
}
