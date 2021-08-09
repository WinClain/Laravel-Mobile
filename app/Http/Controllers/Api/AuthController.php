<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Log;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function signUp (Request $req) {
        $result = json_decode($req->getContent());
        $response = [];
        $log = ['event_name'=>'attempt register'];
        Log::create($log);

        $existUser = User::where('email',$result->email)->first();
        if($existUser !== null){
            $response['error'] = 'user exist';
        }else{
            $user = [];
            $user['email'] = $result->email;
            $user['name'] = $result->name;
            $user['password'] = Hash::make($result->password);

            $createdUser = User::create($user);
            $userProfile = ['user_id'=>$createdUser->id];

            if(UserProfile::create($userProfile)){
                $response['status'] = 'success';
            }else{
                $createdUser->delete();
                $response['status'] = 'error'; 
            }
        }

        return response()->json($response);
    }

    public function signIn (Request $req) {
        $result = json_decode($req->getContent());
        $response = [];
        $log = ['event_name'=>'attempt login'];
        Log::create($log);

        $user = User::where('email',$result->email)->first();
        if($user === null){
            $response['status'] = 'error';
            $response['error'] = 'user is not found';
        }else{
            if(Hash::check($result->password,$user->password)){
                $profile = UserProfile::where('user_id',$user->id)->first();
                $response['status'] = 'success';
                $response['user'] = $user;
                $response['userProfile'] = $profile;
            }else{
                $response['status'] = 'error';
                $response['error'] = 'uncorect password';
            }

        }
        
        return response()->json($response);
    }
}
