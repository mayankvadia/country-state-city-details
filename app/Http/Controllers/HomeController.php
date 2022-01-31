<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 1000);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
Use Session;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $cityCount = $stateCount = $countryCount = 0;
        $countryLimit = 20;
        $stateLimit = 2;
        $cityLimit = 2;
        //For all country and their respective states 
        $response = Http::withoutVerifying()->get('https://countriesnow.space/api/v0.1/countries/states')->json();
        
        //For single country and states of that country 
        // $response = Http::withoutVerifying()->post('https://countriesnow.space/api/v0.1/countries/states', [
        //                     "country"=> 'Nigeria',
        //                 ])->json();
        // $response = Session::get('data');
        if(isset($response['error']) && $response['error'] !== true)
        {
            // echo $response['msg']??'';
            if(isset($response['data']) && !empty($response['data']))
            {
                foreach ($response['data'] as $key=>$countryData) {
                    if(isset($countryData['states']) && !empty($countryData['states']) && $countryCount < $countryLimit)
                    {
                        // $stateLimit = 5;
                        $exististState = [];
                        foreach ($countryData['states'] as $states) {
                            if(!in_array($states['name'],$exististState) && count($exististState) <= $stateLimit )
                            {
                                $exististState[] = $states['name'];
                                $citiesResponse = Http::withoutVerifying()->post('https://countriesnow.space/api/v0.1/countries/state/cities', [
                                            "country"=> $countryData['name'],
                                            "state"=> $states['name']
                                        ])->json();
                                // $citiesResponse = Session::get('citydata');
                                if(isset($citiesResponse['error']) && $citiesResponse['error'] !== true)
                                {
                                    // $cityLimit = 2;
                                    $exististCity = [];
                                    foreach ($citiesResponse['data'] as $city) {
                                        // if($cityCount < $cityLimit)
                                        if(!in_array($city,$exististCity) && count($exististCity) <= $cityLimit )
                                        {
                                            $exististCity[] = $city;
                                            $populationResponse = Http::withoutVerifying()->post('https://countriesnow.space/api/v0.1/countries/population/cities', [
                                                "city"=> $city
                                            ])->json();
                                            if(isset($populationResponse['error']) && $populationResponse['error'] !== true)
                                            {
                                                if(isset($populationResponse['data']['populationCounts']))
                                                {
                                                    $count = $populationResponse['data']['populationCounts'];
                                                }
                                                else
                                                {
                                                    $count = "No data found";
                                                }
                                            }
                                            else
                                            {
                                                $count = $populationResponse['msg'];
                                            }
                                                $data[$countryData['name']][$states['name']][$city]['population']=$count;
                                        }
                                        // $cityCount++;
                                    }

                                }
                                else
                                {
                                    $citiesResponse['msg'];
                                }
                            }
                            // $stateCount++;
                        }
                    $countryCount++;
                    }
               }   
            }
        }
        else
        {
            $response['msg'];            
        }
        return view('hierarchy')->with(['data'=>$data]);
    }
}
