<?php
namespace Tests\Feature\SysAdmin;

use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function testRegister(){
        $tempUser = factory(\App\Models\User::class)->make();

        $response = $this->post("api/register", [
            "name" => $tempUser->name,
            "email" => $tempUser->email,
            "password" => "password"
        ]);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'user'
        ]);
    }


    public function testLogin()
    {
        $user = factory(\App\Models\User::class)->make();

        // TEST 405
        $response = $this->get("/api/login");
        $response->assertStatus(Response::HTTP_METHOD_NOT_ALLOWED );

        // TEST 422
        $response = $this->post("/api/login",[]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure([
            "email",
            "password"
        ]);

        // TEST 404
        $response = $this->post("/api/login", [
            "email" => $user->email,
            "password" => "password"
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertJsonStructure([
            "message",
            "user",
            "token",
        ]);
        
        $user->save();
        //TEST 200
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


    }

}