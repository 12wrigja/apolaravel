<?php

namespace APOSite\Providers;

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
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(1));
        Passport::tokensCan([
                                'view-profile'           => 'View your user profile and profiles of other APO members.',
                                'edit-profile'           => 'View and edit your user profile.',
                                'view-service-reports'   => 'View service report data.',
                                'manage-service-reports' => 'Create and delete service reports as you.',
                                'view-contract-status'   => 'View contract status.',
                            ]);
    }
}
