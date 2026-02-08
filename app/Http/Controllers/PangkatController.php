<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pangkat; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PangkatController extends Controller
{   
    //
    public function index()
    {
        $all_pangkat = Pangkat::all();

        return view('Admin.Settings', compact('all_pangkat'));
    }
    
}