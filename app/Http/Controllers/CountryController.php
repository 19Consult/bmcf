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
        $cities = $this->countries->where('cca2', $code_country)->hydrate('cities')->first()->cities->pluck('name')->toArray();
        return $cities;

    }

    public function allCountries(){
        return $this->countries->all()->pluck('name.common', 'cca2')->toArray();
    }

    public function ajaxGetCities(Request $request){
        $code_country = $request->get('code_country');
        return response()->json(['success' => true, 'cities' => $this->getCities($code_country)]);
    }
}
