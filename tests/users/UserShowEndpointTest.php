<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use APOSite\Http\Controllers\API\UserAPIController as UserAPI;
use Illuminate\Support\Facades\Auth;
use APOSite\Models\Users\Family;

class UserShowEndpointTest extends TestCase
{

    use DatabaseMigrations;

    public function testIndexNeedsAuthentication()
    {
        $this->assertFalse(Auth::check());
        $this->callAPIMethod('GET', '/api/v1/users');
        $this->seeJsonStructure(['error']);
    }

    public function testShowEndpointRequiresViewOrEditProfileScopes()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();

        $validScopes = collect([
            $this->scopeKey(UserAPI::$SCOPE_VIEW_PROFILE),
            $this->scopeKey(UserAPI::$SCOPE_EDIT_PROFILE),
        ]);
        $allScopes = collect(\Laravel\Passport\Passport::scopeIds());
        $scopeTokenMap = $allScopes->map(function ($scope) use ($user) {
            return [$scope => $user->createToken('test token', [$scope])->accessToken];
        })->reduce(function ($initial, $nextItem) {
            return array_merge($initial, $nextItem);
        }, []);
        foreach ($scopeTokenMap as $scope => $token) {
            $this->callAPIMethod('GET', '/api/v1/users/jow6', $token);
            if ($validScopes->contains($scope)) {
                $this->seeJsonStructure(['data']);
            } else {
                $this->seeJsonStructure(['error' => ['token']]);
            }
        }
    }

    public function testCanSeeUserData()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();

        $family = factory(Family::class)->create();
        $user->family()->associate($family);

        $bigUser = $this->buildFakerUser('jow7', 'Jimmy', 'Wright');
        $bigUser->save();
        $user->big()->associate($bigUser);

        $user->save();

        $this->assertEquals($family, $user->family);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('GET', '/api/v1/users/jow6', $token);
        $this->assertResponseOk();
        $this->seeJsonStructure([
            'data' => [
                'first_name',
                'last_name',
                'nickname',
                'email',
                'phone_number',
                'address',
                'city',
                'state',
                'zip_code',
                'campus_residence',
                'biography',
                'join_reason',
                'major',
                'minor',
                'graduation_semester',
                'hometown',
                'family' => [
                    'id',
                    'name'
                ],
                'big' => [
                    'id',
                    'first_name',
                    'last_name',
                    'display_name'
                ],
                'pledge_semester',
                'initiation_semester',
                'contract',
            ]
        ]);
    }
}
