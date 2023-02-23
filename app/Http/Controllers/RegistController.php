<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RegistController extends Controller
{

    protected static $role_md5 = [];

    function __construct(){
        self::$role_md5 = [
            1 => md5("Owner"),
            2 => md5("Investor"),
        ];
    }


    public function signUpFounder(){

//        $role_md5 = Role::$role_md5;
//        var_dump(self::$role_md5);

        return view('sign-up-founder');
    }

}
