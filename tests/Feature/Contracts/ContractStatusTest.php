<?php

namespace Tests\Feature\Contracts;

use APOSite\Http\Controllers\API\UserAPIController;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use APOSite\Http\Controllers\API\UserAPIController as UserAPI;

class ContractStatusTest extends TestCase
{

    use DatabaseMigrations;

    public function testStatusPageNeedsAuthentication()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->assertTrue($user->changeContract("Pledge"));

        $this->assertFalse(Auth::check());
        $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status');
        $response->assertJsonStructure(['error']);
    }


    public function testStatusPageWorksOnlyWithViewContractScope()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();

        $validScopes = collect([
            $this->scopeKey(UserAPI::$SCOPE_VIEW_CONTRACT),
        ]);
        $allScopes = collect(\Laravel\Passport\Passport::scopeIds());
        $scopeTokenMap = $allScopes->map(function ($scope) use ($user) {
            return [$scope => $user->createToken('test token', [$scope])->accessToken];
        })->reduce(function ($initial, $nextItem) {
            return array_merge($initial, $nextItem);
        }, []);
        foreach ($scopeTokenMap as $scope => $token) {
            $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status', $token);
            if ($validScopes->contains($scope)) {
                $response->assertJsonStructure(['data']);
            } else {
                $response->assertJsonStructure(['error' => ['token']]);
            }
        }
    }

    public function testStatusDataIsNotAccessibleToNormalUsers()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->assertTrue($user->changeContract("Pledge"));

        $user1 = $this->buildFakerUser('jow7', 'Jimmy', 'Wright');
        $user1->save();

        $token = $user1->createToken("test_token",
            [$this->scopeKey(UserAPIController::$SCOPE_VIEW_CONTRACT)])->accessToken;

        $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status', $token);
        $response->assertJsonStructure(['error']);
    }

    public function testStatusDataIsAccessibleToMembership()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->assertTrue($user->changeContract("Active"));

        $pledgeEd = $this->buildFakerUserInOffices('jow7', 18);
        $pledgeEd->save();

        $token = $pledgeEd->createToken("test_token",
            [$this->scopeKey(UserAPIController::$SCOPE_VIEW_CONTRACT)])->accessToken;

        $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status', $token);
        $response->assertJsonStructure(['data']);
    }

    public function testPledgeStatusDataIsAccessibleToPledgeEd()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->assertTrue($user->changeContract("Pledge"));

        $pledgeEd = $this->buildFakerUserInOffices('jow7', 10);
        $pledgeEd->save();

        $token = $pledgeEd->createToken("test_token",
            [$this->scopeKey(UserAPIController::$SCOPE_VIEW_CONTRACT)])->accessToken;

        $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status', $token);
        $response->assertJsonStructure(['data']);
    }

    public function testBrotherStatusDataIsNotAccessibleToPledgeEd()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->assertTrue($user->changeContract("Active"));

        $pledgeEd = $this->buildFakerUserInOffices('jow7', 10);
        $pledgeEd->save();

        $token = $pledgeEd->createToken("test_token",
            [$this->scopeKey(UserAPIController::$SCOPE_VIEW_CONTRACT)])->accessToken;

        $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status', $token);
        $response->assertJsonStructure(['error']);
    }

    public function testStatusListsContractStatusData()
    {
        $user = $this->buildFakerUser('jow6', 'James', 'Wright');
        $user->save();
        $this->assertTrue($user->changeContract("Pledge"));

        $scope = UserAPI::$SCOPE_VIEW_CONTRACT;
        $token = $user->createToken('test_token', [$this->scopeKey($scope)])->accessToken;

        $response = $this->callAPIMethod('GET', '/api/v1/users/jow6/status', $token);

        // Default data is id, href (object link), display_name, first_name, last_name, image
        $response->assertJsonStructure([
            'data' => [
                'name',
                'description',
                'semester_id',
                'is_complete',
                'misc_requirements',
                'requirements' => [
                    '*' =>
                        [
                            'name',
                            'description',
                            'threshold',
                            'comparison',
                            'value',
                            'pending_value',
                            'is_complete',
                            'percent_complete'
                        ]
                ]
            ]
        ]);
    }

}
