<?php
namespace Tests\Feature\SysAdmin;

use Illuminate\Http\Response;
use Tests\TestCase;

class GitTest extends TestCase
{

    public function testGitUsernameDetails()
    {
        // TEST 405
        $response = $this->get("/api/git/usernames");
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED );

        // TEST 422
        $response = $this->post("/api/git/usernames",[], []);
        $response->assertStatus(Response::HTTP_FORBIDDEN);

        $user = factory(\App\Models\User::class)->create();

        $response = $this->post("/api/login", [
            "email" => $user->email,
            "password" => "password",
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            "message",
            "user" => [
                "email",
                "name"
            ],
            "token",
        ]);

        $user = $this->decode($response);
        $response = $this->post("/api/git/usernames", [
            "usernames" => [
//                "mojombo",
//                "zedektador",
//                "defunkt",
//                "pjhyett",
//                "wycats",
//                "ezmobius",
//                "ivey",
//                "evanphx",
//                "vanpelt",
                "dsadsadsasadsad;l,sal;,awpo"
            ]
        ],[
            "Authorization" => $user->token
        ]);
        $response->assertStatus(Response::HTTP_OK);

    }

}