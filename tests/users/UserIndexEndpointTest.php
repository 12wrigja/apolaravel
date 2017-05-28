<?php

use APOSite\Http\Controllers\API\UserAPIController as UserAPI;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use APOSite\Models\Users\User;

class UserIndexEndpointTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexNeedsAuthentication()
    {
        $this->assertFalse(Auth::check());
        $this->callAPIMethod('GET', '/api/v1/users');
        $this->seeJsonStructure(['error']);
    }

    public function testIndexWorksOnlyWithViewOrEditProfileScope()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->signInAs($user->id);

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
            $this->callAPIMethod('GET', '/api/v1/users', $token);
            if ($validScopes->contains($scope)) {
                $this->seeJsonStructure(['data']);
            } else {
                $this->seeJsonStructure(['error']);
            }
        }
    }

    public function testIndexListsUserDefaultData()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('GET', '/api/v1/users', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonEquals([
            'data' => [
                '0' => [
                    'id' => 'jow6',
                    'first_name' => 'James',
                    'last_name' => 'Wright',
                    'display_name' => 'James Wright',
                    'image' => 'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?s=150&d=mm',
                    'href' => 'http://localhost/api/v1/users/jow6'
                ]
            ]
        ]);
    }

    public function testIndexDisplaysDefaultDataForAllUsers()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        // Make some more users
        factory(User::class, 5)->create();

        $this->callAPIMethod('GET', '/api/v1/users', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'display_name',
                    'image',
                    'href'
                ]
            ]
        ]);
    }

    public function testIndexDisplaysAdditionalRequestedData()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        // Make some more users
        factory(User::class, 5)->create();

        $this->callAPIMethod('GET', '/api/v1/users?attrs=address', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'display_name',
                    'image',
                    'href',
                    'address',
                ]
            ]
        ]);
    }

    public function testIndexFailsOnInvalidSearchKey()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        // Make some more users
        factory(User::class, 5)->create();

        // Note in this call, we deliberately mis-spell attrs, and so it is interpreted as a search filter. User's don't
        // have an 'aatrs' attribute, so the query will fail.
        $this->callAPIMethod('GET', '/api/v1/users?aatrs=address', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonStructure(['error']);
    }

    public function testIndexCanRestrictOnAttributeExactValues()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $user1 = $this->buildFakerUser('abc', 'Alice', 'Wright');
        $user1->save();
        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('GET', '/api/v1/users?first_name=James', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonEquals([
            'data' => [
                '0' => [
                    'id' => 'jow6',
                    'first_name' => 'James',
                    'last_name' => 'Wright',
                    'display_name' => 'James Wright',
                    'image' => 'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?s=150&d=mm',
                    'href' => 'http://localhost/api/v1/users/jow6'
                ]
            ]
        ]);
    }

    public function testIndexAttributeSearchIsCaseInsensitive()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $user1 = $this->buildFakerUser('abc', 'Alice', 'Wright');
        $user1->save();
        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('GET', '/api/v1/users?first_name=james', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonEquals([
            'data' => [
                '0' => [
                    'id' => 'jow6',
                    'first_name' => 'James',
                    'last_name' => 'Wright',
                    'display_name' => 'James Wright',
                    'image' => 'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?s=150&d=mm',
                    'href' => 'http://localhost/api/v1/users/jow6'
                ]
            ]
        ]);
    }

    public function testIndexSearchByNondefaultAttributeIncludesAttributeInResponse()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->address="501 Park Place";
        $user->save();
        $user1 = $this->buildFakerUser('abc', 'Alice', 'Wright');
        $user->address="504 Parc Place";
        $user1->save();

        $this->signInAs($user->id);

        $scope = UserAPI::$SCOPE_VIEW_PROFILE;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $this->callAPIMethod('GET', '/api/v1/users?address=501%20park%20place', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $this->seeJsonEquals([
            'data' => [
                '0' => [
                    'id' => 'jow6',
                    'first_name' => 'James',
                    'last_name' => 'Wright',
                    'display_name' => 'James Wright',
                    'image' => 'http://www.gravatar.com/avatar/d41d8cd98f00b204e9800998ecf8427e?s=150&d=mm',
                    'href' => 'http://localhost/api/v1/users/jow6',
                    'address' => '501 Park Place',
                ]
            ]
        ]);
    }
}
