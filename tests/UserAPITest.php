<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserAPITest extends TestCase
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
        $this->callAPIMethod('GET','/api/v1/users');
        $this->seeJsonStructure(['error']);
    }

    public function testIndexWithAuth()
    {
        $this->assertFalse(Auth::check());
        $user = $this->buildFakerUser('jow5','James','Wright');
        $user->save();
        $this->signInAs($user->id);
        $token = $user->createToken('test-token',['view-profile'])->accessToken;
        $this->callAPIMethod('GET','/api/v1/users', $token);
        $this->seeJsonStructure(['data']);
    }
}
