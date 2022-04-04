<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class PlacesService extends AbstractService
{
    protected $payload;

    const API_URL = '/v3/places/nearby';

    public function __construct()
    {
        $this->baseUrl = env('FOUR_SQUARE_URL');
        parent::__construct();
    }

    public function call(): AbstractService
    {
        try {
            $response = $this->get(
                trim(self::API_URL),
                $this->getPayload(),
                null,
                $this->buildHeaders());

            $this->status = $response->status;
            $this->response = $this->status == 200 ? $response->result : false;

//            Log::info('Response : ', [$response]);
        } catch (\Exception $exception) {
            Log::info('Error Response : ', [$exception->getMessage()]);
            $this->response = 500;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param mixed $payload
     * @return WeatherService
     */
    public function setPayload(array $payload): PlacesService
    {
        $this->payload =  $payload;
        return $this;
    }

    public function buildHeaders()
    {
        return [
            "Authorization" => env('FOUR_SQUARE_URL_API_KEY')
        ];
    }

}
