<?php

namespace App\Http\Controllers;

use App\Models\Log;
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
        $logs = Log::get();
        return view('debug-view',compact('logs'));
    }
}
