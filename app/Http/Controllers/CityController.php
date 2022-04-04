<?php

namespace App\Http\Controllers;

use App\Services\PlacesService;
use App\Services\WeatherService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $request;
    protected $weatherService;
    protected $placesService;

    public function __construct(
        Request $request,
        WeatherService $weatherService,
        PlacesService $placesService
    )
    {
        $this->request        = $request;
        $this->weatherService = $weatherService;
        $this->placesService  = $placesService;
    }
    public function index($city)
    {
        $weather_response = $this->weatherService->setPayload([
            'q' => $city
        ])->call()->response();
        if($weather_response == false) {
            return response()->json([
                "message" => "City Not found"
            ], 404);
        }
        $places = $this->placesService->setPayload([
            'll' => $weather_response->city->coord->lat.",".$weather_response->city->coord->lon,
            "limit" => 5
        ])->call()->response();

        return response()->json([
            "weather" => $weather_response,
            "venues" => $places,
            "message" => "Successfully Retrieved Details."
        ], 200);
        return ;
    }
}
