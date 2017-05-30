<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use APOSite\Http\Controllers\API\UserAPIController as UserAPI;
use APOSite\Models\Users\User;

class UserDeleteEndpointTest extends TestCase
{

    use DatabaseMigrations;

    public function testNormalUsersCantDeleteOtherUsers()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();

        $user1 = $this->buildFakerUser('jow7', 'Jimmy','Wright');
        $user1->save();
        $jimmy = User::find('jow7');
        $this->assertNotNull($jimmy);


        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('DELETE', '/api/v1/users/jow7', $token);
        $this->seeJsonStructure(['error']);

        $jimmy = User::find('jow7');
        $this->assertNotNull($jimmy);
    }

    public function testDeleteUsersRequiresManageUsersScope()
    {
        $user = $this->buildFakerUserInOffices('jow6', 1);
        $user->save();

        $user1 = $this->buildFakerUser('jow7', 'Jimmy','Wright');
        $user1->save();
        $jimmy = User::find('jow7');
        $this->assertNotNull($jimmy);

        $allScopes = collect(\Laravel\Passport\Passport::scopeIds());
        $allScopes = $allScopes->filter(function($scope) {
            return $scope != $this->scopeKey(UserAPI::$SCOPE_MANAGE_USERS);
        });
        $scopeTokenMap = $allScopes->map(function ($scope) use ($user) {
            return [$scope => $user->createToken('test token', [$scope])->accessToken];
        })->reduce(function ($initial, $nextItem) {
            return array_merge($initial, $nextItem);
        }, []);
        foreach ($scopeTokenMap as $scope => $token) {
            $this->callAPIMethod('DELETE', '/api/v1/users/jow7', $token);
            $this->seeJsonStructure(['error'=>['token']]);
        }
    }

    public function testDeletingUserAsWebmasterWorksAndOnlySoftDeletes()
    {
        $user = $this->buildFakerUserInOffices('jow6', 1);
        $user->save();
        $user1 = $this->buildFakerUser('jow7', 'Jimmy','Wright');
        $user1->save();

        $jimmy = User::find('jow7');
        $this->assertNotNull($jimmy);

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('DELETE', '/api/v1/users/jow7', $token);
        $this->assertResponseOk();
        $this->seeJsonStructure(['status']);

        $jimmy = User::find('jow7');
        $this->assertNull($jimmy);

        $jimmy = User::withTrashed()->find('jow7');
        $this->assertNotNull($jimmy);
    }

    public function testDeletingPledgeUserAsPledgeEdWorksAndOnlySoftDeletes()
    {
        $user = $this->buildFakerUserInOffices('jow6', 10);
        $user->save();

        $user1 = $this->buildFakerUser('jow7', 'Jimmy','Wright');
        $user1->save();
        $jimmy = User::find('jow7');
        $this->assertNotNull($jimmy);
        $jimmy->changeContract('Pledge');

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('DELETE', '/api/v1/users/jow7', $token);
        $this->assertResponseOk();
        $this->seeJsonStructure(['status']);

        $jimmy1 = User::find('jow7');
        $this->assertNull($jimmy1);

        $jimmy1 = User::withTrashed()->find('jow7');
        $this->assertNotNull($jimmy1);
    }
}
