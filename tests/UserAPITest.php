<?php

use Illuminate\Support\Facades\Auth;

class UserAPITest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexNeedsAuthentication()
    {
        $this->assertFalse(Auth::check());
        $this->json('GET','/api/v1/users');
    }
}
