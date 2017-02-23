<?php

use APOSite\Http\Controllers\API\UserAPIController as UserAPI;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

class UserAPITest extends TestCase {

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexNeedsAuthentication() {
        $this->assertFalse(Auth::check());
        $this->callAPIMethod('GET', '/api/v1/users');
        $this->seeJsonStructure(['error']);
    }

    public function testIndexWorksOnlyWithViewOrEditProfileScope() {
        $user = $this->buildFakerUser('jow5', 'James', 'Wright');
        $user->save();
        $this->signInAs($user->id);

        $validScopes = collect([
                                   $this->scopeKey(UserAPI::$SCOPE_VIEW_PROFILE),
                                   $this->scopeKey(UserAPI::$SCOPE_EDIT_PROFILE),
                               ]);
        $allScopes = collect(\Laravel\Passport\Passport::scopeIds());
        $scopeTokenMap = $allScopes->map(function($scope) use ($user) {
           return [$scope=>$user->createToken('test token',[$scope])->accessToken];
        })->reduce(function($initial, $nextItem){
            return array_merge($initial, $nextItem);
        }, []);
        foreach ($scopeTokenMap as $scope=>$token) {
            $this->callAPIMethod('GET', '/api/v1/users', $token);
            if ($validScopes->contains($scope)) {
                $this->seeJsonStructure(['data']);
            } else {
                $this->seeJsonStructure(['error']);
            }
        }
    }
}
