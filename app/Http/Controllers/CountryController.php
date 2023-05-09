<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;
use PragmaRX\Countries\Package\Services\Config;


class CountryController extends Controller
{

    protected $countries;


    public function __construct(){
        $this->countries = new Countries();
    }

    function index(){

    }

    public function getCities($code_country){
//        echo 11111111111111111111;
//        var_dump($code_country); die();
//        if(empty($code_country) && !isset($code_country)){
//            return [];
//        }
        $cities = $this->countries->where('cca2', $code_country)->hydrate('cities')->first()->cities->pluck('name')->toArray();
        return $cities;

    }

    public function allCountries(){
        return $this->countries->all()->pluck('name.common', 'cca2')->toArray();
    }

    public function ajaxGetCities(Request $request){
        $code_country = $request->get('code_country');
        //return response()->json(['1' => $code_country]);
        return response()->json(['success' => true, 'cities' => $this->getCities($code_country)]);
    }

    public function getNameCountry($code){
        return $this->countries->where('cca2', $code)->first()->name->common;
    }

    public function getCodeCountry($code){
        if(isset($this->countries->where('name.common', $code)->first()->cca2)){
            return $this->countries->where('name.common', $code)->first()->cca2;
        }
        return false;
    }
}
