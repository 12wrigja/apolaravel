<?php

namespace Tests\Unit;

use APOSite\Http\Controllers\Auth\LoginController;
use APOSite\Interfaces\SSOService;
use APOSite\Models\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit_Framework_Assert as PHPUnit;
use Tests\TestCase;
use Mockery;
use ReflectionClass;

class LoginControllerTest extends TestCase {

    use DatabaseMigrations;

    public function assertRedirectedToStartsWith(TestResponse $response, $uri, $with = []) {
        PHPUnit::assertInstanceOf('Illuminate\Http\RedirectResponse', $response->baseResponse);

        PHPUnit::assertStringStartsWith($this->app['url']->to($uri),
                                        $response->baseResponse->headers->get('Location'));

        $response->assertSessionHasAll($with);

        return $this;
    }

    public function testAuthMiddlewareDirectsToSSOIfNotLoggedIn() {
        self::assertFalse(Auth::check());
        $response = $this->call('GET', route('login'));
        $this->assertRedirectedToStartsWith($response,'https://login.case.edu/');
    }

    public function testAuthMiddlewareBuildsCredentialsCorrectly() {
        $request = new Request([], [], ['ticket' => 'abcdefg'], [], [], [], null);

        $ssoServiceMock = Mockery::mock(SSOService::class);
        $ssoServiceMock->shouldReceive('credentialsFromRequest')
                       ->withArgs([$request,
                                   route('login')])
                       ->andReturn(['id' => 'testuser']);

        $loginController = new LoginController($ssoServiceMock);
        $loginControllerShadow = new ReflectionClass($loginController);
        $loginMethodShadow = $loginControllerShadow->getMethod('credentials');
        $loginMethodShadow->setAccessible(true);

        $returnedCreds = $loginMethodShadow->invokeArgs($loginController, [$request]);
        $this->assertArrayHasKey('id', $returnedCreds);
        $this->assertEquals('testuser',$returnedCreds['id']);
        $this->assertArrayHasKey('password', $returnedCreds);
        $this->assertEquals('', $returnedCreds['password']);
    }

    public function testAuthMiddlewareStripsPasswordFromCredentialsCorrectly() {
        $request =
            new Request([], [], ['ticket' => 'abcdefg', 'password' => 'wxyz'], [], [], [], null);

        $ssoServiceMock = Mockery::mock(SSOService::class);
        $ssoServiceMock->shouldReceive('credentialsFromRequest')
                       ->withArgs([$request,
                                   route('login')])
                       ->andReturn(['id' => 'testuser', 'password'=>'wxyz']);

        $loginController = new LoginController($ssoServiceMock);
        $loginControllerShadow = new ReflectionClass($loginController);
        $loginMethodShadow = $loginControllerShadow->getMethod('credentials');
        $loginMethodShadow->setAccessible(true);

        $returnedCreds = $loginMethodShadow->invokeArgs($loginController, [$request]);
        $this->assertArrayHasKey('id', $returnedCreds);
        $this->assertEquals('testuser',$returnedCreds['id']);
        $this->assertArrayHasKey('password', $returnedCreds);
        $this->assertEquals('', $returnedCreds['password']);
    }

    public function testLoginControllerAddsCredentialsToRequest(){
        $request =
            new Request([], [], ['ticket' => 'abcdefg', 'password' => 'wxyz'], [], [], [], null);

        $this->assertFalse($request->has('option3'));

        $ssoServiceMock = Mockery::mock(SSOService::class);
        $ssoServiceMock->shouldReceive('credentialsFromRequest')
                       ->withArgs([$request,
                                   route('login')])
                       ->andReturn(['id' => 'testuser', 'password'=>'wxyz', 'option3'=>'5678']);

        $loginController = new LoginController($ssoServiceMock);
        $loginControllerShadow = new ReflectionClass($loginController);
        $loginMethodShadow = $loginControllerShadow->getMethod('credentials');
        $loginMethodShadow->setAccessible(true);

        $returnedCreds = $loginMethodShadow->invokeArgs($loginController, [$request]);

        // Check to make sure that the credentials array (which Laravel uses to lookup users)
        // only has the 'id' and 'password' keys.
        $this->assertArrayHasKey('id', $returnedCreds);
        $this->assertEquals('testuser',$returnedCreds['id']);
        $this->assertArrayHasKey('password', $returnedCreds);
        $this->assertEquals('', $returnedCreds['password']);
        $this->assertArrayNotHasKey('option3', $returnedCreds);

        // Check to make sure the request has all the things in it from the SSO Service Array.
        $this->assertTrue($request->has('option3'));
        $this->assertEquals('5678', $request->get('option3'));
        $this->assertTrue($request->has('id'));
        $this->assertEquals('testuser', $request->get('id'));
        $this->assertTrue($request->has('password'));
        $this->assertEquals('wxyz',$request->get('password'));

    }

    public function testAuthMiddlewareEndToEndWithValidUser() {
        // Build and bind a mock of the SSO Service.
        $fakeSSOURL = "https://example.com/login";
        $ssoServiceMock = Mockery::mock(SSOService::class);
        $this->app->instance(SSOService::class, $ssoServiceMock);

        $appLoginUrl = route('login');

        // Build a fake user. Save them so they can be found later in the DB by the login
        // controller.
        $fakeUser = new User();
        $fakeUser->id = 'testuser';
        $fakeUser->first_name = 'Fake';
        $fakeUser->last_name = ' User';
        $fakeUser->save();

        // Check we aren't already authenticated, and then kickoff the login flow.
        self::assertFalse(Auth::check());

        $ssoServiceMock->shouldReceive('getSSOLoginRedirectURL')->andReturn($fakeSSOURL .
                                                                            '?service=' .
                                                                            $appLoginUrl);
        $ssoServiceMock->shouldReceive('isRequestFromSSOServiceCallback')
                       ->times(1)
                       ->andReturn(false);
        $response = $this->call('GET', route('login'));
        $this->assertRedirectedToStartsWith($response, $fakeSSOURL);

        // We've been redirected. Let's then call the callback with a ticket
        $ticket = "afaketicketforthefakeuser.";

        // Setup Mock expectations.
        $ssoServiceMock->shouldReceive('isRequestFromSSOServiceCallback')
                       ->times(1)
                       ->andReturn(true);
        $ssoServiceMock->shouldReceive('getSSOCallbackValidationRules')
                       ->times(1)
                       ->withArgs([any(Request::class)])
                       ->andReturn(['ticket' => 'required']);
        $ssoServiceMock->shouldReceive('credentialsFromRequest')
                       ->times(1)
                       ->withArgs([any(Request::class), route('login')])
                       ->andReturn(['id' => 'testuser']);

        // Let's actually do the callback from the SSO Service now, and see that we get logged in
        // correctly.
        $this->call('GET', route('login'), ['ticket' => $ticket]);
        $this->assertTrue(Auth::check());
        $loggedInUser = Auth::user();
        $this->assertEquals($fakeUser->id, $loggedInUser->id);

        // Do a last minute check to see exactly who is logged in.
        $response = $this->get('/whoami');
        $response->assertSuccessful();
        $response->assertSee($fakeUser->id);
    }

    public function testAuthMiddlewareEndToEndWithInvalidUser() {
        // Build and bind a mock of the SSO Service.
        $fakeSSOURL = "https://example.com/login";
        $ssoServiceMock = Mockery::mock(SSOService::class);
        $this->app->instance(SSOService::class, $ssoServiceMock);

        $appLoginUrl = route('login');

        // Unlike the last test, we are NOT going to build a fake user. This means when the
        // user logs in the SSO correctly that they should be redirected to the 401 page.

        // Check we aren't already authenticated, and then kickoff the login flow.
        self::assertFalse(Auth::check());

        $ssoServiceMock->shouldReceive('getSSOLoginRedirectURL')->andReturn($fakeSSOURL .
                                                                            '?service=' .
                                                                            $appLoginUrl);
        $ssoServiceMock->shouldReceive('isRequestFromSSOServiceCallback')
                       ->times(1)
                       ->andReturn(false);
        $response = $this->call('GET', route('login'));
        $this->assertRedirectedToStartsWith($response, $fakeSSOURL);

        // We've been redirected. Let's then call the callback with a ticket
        $ticket = "afaketicketforthefakeuser.";

        // Setup Mock expectations.
        $ssoServiceMock->shouldReceive('isRequestFromSSOServiceCallback')
                       ->times(1)
                       ->andReturn(true);
        $ssoServiceMock->shouldReceive('getSSOCallbackValidationRules')
                       ->times(1)
                       ->withArgs([any(Request::class)])
                       ->andReturn(['ticket' => 'required']);
        $ssoServiceMock->shouldReceive('credentialsFromRequest')
                       ->times(1)
                       ->withArgs([any(Request::class), route('login')])
                       ->andReturn(['id' => 'testuser']);

        // Let's actually do the callback from the SSO Service now, and see that we get don't get
        // logged in.
        $response = $this->call('GET', route('login'), ['ticket' => $ticket]);
        $this->assertFalse(Auth::check());
        $response->assertRedirect('401');
    }

}
