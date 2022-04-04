<?php
/**
 * Created by PhpStorm.
 * User: zed
 * Date: 4/4/2022
 * Time: 6:29 PM
 */

namespace App\Http\Controllers;


use App\Services\GitService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class GitController
{
    const USERNAME_LIMIT = 10;
    protected $gitService;
    protected $placesService;

    public function __construct(
        GitService $gitService
    ) {
        $this->gitService = $gitService;
    }

    public function details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "usernames" => "required|array|max:10|distinct"
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $response = [];
        foreach($request->post('usernames') as $username) {
            if(Cache::has($username)) {
                array_push($response, Cache::get($username));
            } else {
                $gitResponse = $this->gitService->setApiUrl($username)->call()->response();
                if($gitResponse) {
                    $expiresAt = Carbon::now()->addMinutes(2);
                    $details =  (object)[
                        "name" => $gitResponse->name,
                        "login" => $gitResponse->login,
                        "company" => $gitResponse->company,
                        "followers" => $gitResponse->followers,
                        "public_repos" => $gitResponse->public_repos,
                        "ave_followers" => ($gitResponse->followers/$gitResponse->public_repos),
                    ];
                    Cache::put($username, $details, $expiresAt);
                    array_push($response, $details);
                }
            }
        }

        return response()->json([
            "details" => $response
        ], 200);
    }
}