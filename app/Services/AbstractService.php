<?php

namespace App\Services;


abstract class AbstractService extends CurlService
{
    const API_URL = '/api';

    protected $response;

    protected $status;

    protected static $mockResponseData = [];

    protected static $mockResponseStatus = 200;

    public function __construct()
    {
        parent::__construct();
    }

    abstract public function call(): AbstractService;

    protected function testOnly()
    {
        return env('APP_ENV') == 'testing';
    }

    protected function mock() {
        $this->response = self::getMockResponseData();
        $this->status = self::getMockResponseStatus();
        return $this;
    }

    public function response()
    {
        return $this->response;
    }

    public function getResponseStatus()
    {
        return $this->status;
    }


    public static function mockResponse($data = [], int $status = 200) {
        self::$mockResponseData = $data;
        self::$mockResponseStatus = $status;
    }

    public static function mockResponseStatus($status) {
        self::$mockResponseStatus = $status;
    }

    public static function mockResponseData($data) {
        self::$mockResponseData = $data;
    }

    protected static function getMockResponseData() {
        return self::$mockResponseData;
    }

    protected function getMockResponseStatus() {
        return self::$mockResponseStatus;
    }
}
