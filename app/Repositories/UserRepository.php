<?php
/**
 * Repository that handle user objects
 */
namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class UserRepository extends AbstractRepository
{

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function login($email, $password)
    {
        $user = $this->model
            ->where('email', $email)
            ->first();

        if(!$user){
            return (object)[
                "status" => 404,
                "message" => __("messages.user.login.404"),
                "token" => null,
                "user" => null,
            ];
        }


        if( Hash::check($password, $user->password) ){
            return (object)[
                "status" => 200,
                "message" => null,
                "token" => $this->generateJWTToken($user),
                "user" => $user,
            ];
        }

        return (object)[
            "status" => 401,
            "message" => __("messages.user.login.400"),
            "token" => null,
            "user" => null,
        ];
    }

    public function generateJWTToken(User $user)
    {
        $exp = Carbon::now()->addHours(1)->timestamp;

        $payload = [
            'iss' => env('SERVICE_NAME'), // Issuer of the token
            'sub' => $user->uuid, // Subject of the token
            'iat' => Carbon::now()->timestamp, // Time when JWT was issued.
            'exp' => $exp, // Expiration time
            'user' => $user->toArray() // user
        ];

        return JWT::encode($payload, config('jwt.private-key.user'), 'RS256');
    }

}