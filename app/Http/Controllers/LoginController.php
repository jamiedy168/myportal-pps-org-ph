<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceEmail;
use App\Models\Nationality;


class LoginController extends Controller
{
    //

    public function applyMember($type)
    {
     
        $nationality = Nationality::where('tbl_nationality.is_active',true)
        ->orderBy('tbl_nationality.nationality_name', 'ASC')
        ->get();


        return view('register.reg',compact('nationality','type'));
    }
}
