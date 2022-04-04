<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    const LOGIN_RULES = [
        "email" => "required",
        "password" => "required"
    ];
    protected $repository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request) {
        // VALIDATION //
        $validator = Validator::make($request->all(), self::LOGIN_RULES);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $login = $this->repository->login($request->post('email'), $request->post('password'));

        if ($login->status == 200) {
            return response()->json([
                "message" => null,
                "user" => $login->user,
                "token" => $login->token,
            ]);
        }

        return response()->json([
            "message" => $login->message,
            "user" => null,
            "token" => null,
        ], $login->status);
    }

}
