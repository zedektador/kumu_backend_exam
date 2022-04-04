<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class GitService extends AbstractService
{
    protected $payload;

    protected $apiURL;

    public function __construct()
    {
        $this->baseUrl = "https://api.github.com";
        $this->apiURL = "users";
        parent::__construct();
    }

    public function call(): AbstractService
    {
        try {
            $response = $this->get(
                trim($this->apiURL),
                $this->getPayload(),
                null,
                $this->getHeaders());

            $this->status = $response->status;
            $this->response = $this->status == 200 ? $response->result : false;

            Log::info("Response : $this->apiURL", [$response]);
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
     * @return GitService
     */
    public function setPayload(array $payload): GitService
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param mixed $apiUrl
     * @return GitService
     */
    public function setApiUrl($apiUrl): GitService
    {
        $this->apiURL = $this->apiURL."/".$apiUrl;
        return $this;
    }

    public function getHeaders()
    {
        return [
            "Accept" =>  "application/vnd.github.v3+json"
        ];
    }
}
