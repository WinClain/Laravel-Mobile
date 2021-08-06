<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DebugController extends Controller
{
    public function myDebug ($data){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function debug() {
        $user = User::where('email','sdsdsd')->first();
        $this->myDebug($user);
        return view('debug-view');
    }
}
