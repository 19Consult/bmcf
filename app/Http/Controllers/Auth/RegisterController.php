<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roidle' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $role_id = array_search ($data['roidle'], app("roleIdMD5_register"));
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role_id
        ]);
    }

    /**
     * Form for /sign-up-founder
     * Owner/Investor
     */

    public function registerType2(Request $request){
        $this->validatorType2($request->all())->validate();
        event(new Registered($user = $this->createType2($request->all())));
        $this->guard()->login($user);
        if ($response = $this->registered($request, $user)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    public function showRegistrationFormType2(){
        $role_token = app("roleIdMD5_register");
        return view('sign-up-founder', ['role_md5' => $role_token[2]]);
    }

    public function showRegistrationFormType3(){
        $role_token = app("roleIdMD5_register");
        return view('sign-up-co-founder', ['role_md5' => $role_token[3]]);
    }

    protected function validatorType2(array $data){
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roidle' => ['required'],
        ]);
    }


    protected function createType2(array $data)
    {
        $role_id = array_search ($data['roidle'], app("roleIdMD5_register"));
        return User::create([
            'name' => ' ',
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role_id
        ]);
    }



}
