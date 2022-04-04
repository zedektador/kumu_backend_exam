<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WeatherService extends AbstractService
{
    protected $payload;

    const API_URL = '/data/2.5/forecast';

    public function __construct()
    {
        $this->baseUrl = env('OPEN_WEATHER_URL');
        parent::__construct();
    }

    public function call(): AbstractService
    {
        try {
            $response = $this->get(
                trim(self::API_URL),
                $this->getPayload(),
                null,
                []);

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
    public function setPayload(array $payload): WeatherService
    {
        $app_id = env('OPEN_WEATHER_API_KEY');

        $this->payload = array_merge([
            'appid' => $app_id
        ], $payload);
        return $this;
    }

}
