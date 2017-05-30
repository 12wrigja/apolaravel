<?php

namespace APOSite\Providers;

use APOSite\Http\Controllers\API\UserAPIController;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'APOSite\Model' => 'APOSite\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();
        Passport::ignoreMigrations();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(1));
        Passport::tokensCan(array_merge(UserAPIController::$SCOPE_VIEW_PROFILE,
                                        UserAPIController::$SCOPE_EDIT_PROFILE,
                                        UserAPIController::$SCOPE_MANAGE_USERS));
    }

}
