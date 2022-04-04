<?php
/**
 * Service Provider that handle the registration of configurations
 */
namespace App\ApiAuth;

use Illuminate\Support\ServiceProvider;

/**
 * Service Provider that handle the registration of configurations
 */
class TokenAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Configuration //
        config(['jwt' => require app()->path() . '/../config/jwt.php' ]);

        $this->app->router->get("/", function(){
            return response()->json([
                "message" => "Access Denied"
            ]);
        });
    }
}