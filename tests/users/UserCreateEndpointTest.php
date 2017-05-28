<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use APOSite\Http\Controllers\API\UserAPIController as UserAPI;
use APOSite\Models\Users\User;

class UserCreateEndpointTest extends TestCase
{

    use DatabaseMigrations;

    public function testNormalUsersCantCreateOtherUsers()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('POST', '/api/v1/users', $token, [
            'cwru_id'=>'jow7',
            'first_name' => 'Jimmy',
            'last_name' => 'Wright',
        ]);
        $this->seeJsonStructure(['error']);
    }

    public function testCreateUsersRequiresManageUsersScope()
    {
        $user = $this->buildFakerUserInOffices('jow6', 1);
        $user->save();

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
            $this->callAPIMethod('POST', '/api/v1/users', $token, [
                'cwru_id' => 'jow7',
                'first_name' => 'Jimmy',
                'last_name' => 'Wright',
            ]);
            $this->seeJsonStructure(['error'=>['token']]);
        }
    }

    public function testCreatingUserAsWebmasterHasBasicRestrictions()
    {
        $user = $this->buildFakerUserInOffices('jow6', 1);
        $user->save();

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('POST', '/api/v1/users', $token, []);
        $this->seeJsonStructure(['error'=>['validation'=>['cwru_id','first_name','last_name']]]);
    }

    public function testCreatingUserAsWebmasterMakesThemAPledge()
    {
        $user = $this->buildFakerUserInOffices('jow6', 1);
        $user->save();

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('POST', '/api/v1/users', $token, [
            'cwru_id' => 'jow7',
            'first_name' => 'Jimmy',
            'last_name' => 'Wright',
        ]);
        $this->seeJsonStructure(['status']); // TODO(12wrigja): change the creation responses to return something useful?

        $jimmy = User::find('jow7');
        $this->assertEquals('Pledge', $jimmy->contract);
    }

    public function testCreatingUserAsPledgeEdHasBasicRestrictions()
    {
        $user = $this->buildFakerUserInOffices('jow6', 10);
        $user->save();

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('POST', '/api/v1/users', $token, []);
        $this->seeJsonStructure(['error'=>['validation'=>['cwru_id','first_name','last_name']]]);
    }

    public function testCreatingUserAsPledgeEducatorMakesThemAPledge()
    {
        $user = $this->buildFakerUserInOffices('jow6', 10);
        $user->save();

        $scope = UserAPI::$SCOPE_MANAGE_USERS;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('POST', '/api/v1/users', $token, [
            'cwru_id' => 'jow7',
            'first_name' => 'Jimmy',
            'last_name' => 'Wright',
        ]);
        $this->seeJsonStructure(['status']); // TODO(12wrigja): change the creation responses to return something useful?

        $jimmy = User::find('jow7');
        $this->assertEquals('Pledge', $jimmy->contract);
    }
}
