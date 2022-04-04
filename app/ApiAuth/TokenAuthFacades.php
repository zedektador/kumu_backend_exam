<?php
/**
 * Decrypt the JWT Authorization Token
 */

namespace App\ApiAuth;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Firebase\JWT\SignatureInvalidException;

/**
 * Decrypt the JWT Authorization Token
 */
class TokenAuthFacades
{
    /**
     * Validate Authorization header
     *
     * @param \Illuminate\Http\Request $request Request object
     * @return object
     */
    public static function validateToken(Request $request, $role)
    {
        $jwt = $request->header('Authorization');
        $publicKey = config('jwt.public-key.' . $role);

        if(!$jwt) {
            return (object)[
                "status" => 403,
                "user" => null,
                "message" => config('user.message-403'),
            ];
        }

        try{
            return (object)[
                "status" => 200,
                "token" => JWT::decode($jwt, new Key($publicKey, 'RS256'), ['RS256']),
                "message" => null
            ];
        } catch(SignatureInvalidException $e) {
            return (object)[
                "status" => 403,
                "user" => null,
                "message" => config('user.message-403'),
            ];
        } catch (ExpiredException $e) {
            return (object)[
                "status" => 419,
                "user" => null,
                "message" => config('user.message-419'),
            ];
        }
    }

    /**
     * Get the current user object from the Authorization header
     *
     * @param \Illuminate\Http\Request $request Request object
     * @return object
     */
    public static function getUser(Request $request, $role)
    {
        $validate = self::validateToken($request, $role);

        switch($validate->status)
        {
            case 200: return $validate->token->user;
            default: return null;
        }
    }
}