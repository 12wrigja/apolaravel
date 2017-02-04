<?php

namespace APOSite\Http\Controllers\Auth;

use APOSite\Http\Controllers\Controller;
use APOSite\Interfaces\SSOService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
     * This controller handles the process of logging in and out, and dealing with the various
     * issues that come with that. The way that Single Sign On works is as follows:
     *
     *  - A user goes to a page that requires authentication, or explicitly goes to log in.
     *  - Laravel detects that a user wants to log in, and so goes to "show the login form" by
     * calling #showLoginForm below.
     *  - We then ask the SSO Service how to get to it's login page (using
     * #getSSOLoginRedirectURL) and redirect there. This in the case of CWRU is the CWRU Single
     * Sign On page, located at https://login.case.edu/login.
     *  - We redirect to this URL, which is specially created to include a way to redirect back
     * to this site when the auth flow succeeds. In the case of the CWRU SSO this is done using a
     *  ?service= URI parameter. In our case, we redirect back to the Login URI.
     *  - Redirecting back to the Login URI causes #showLoginForm to be called again. This time,
     * the SSO Service notifies us that this request looks like a request that could be a
     * callback from the service, so we attempt to log them in.
     *  - If this succeeds, the Laravel internal system will redirect them to their intended
     * location. If there was not an intended location (which is the case when you explicitly go
     * to login) then we redirect to the $redirectTo URI.
     */

    use AuthenticatesUsers {
        sendLoginResponse as originalLoginResponse;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $signOnService;

    /**
     * Create a new LoginController and tell it what Single Sign On service to use when
     * authenticating.
     *
     * @param SSOService $signOnService
     */
    public function __construct(SSOService $signOnService)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->signOnService = $signOnService;
    }

    public function showLoginForm(Request $request)
    {
        if ($this->signOnService->isRequestFromSSOServiceCallback($request)) {
            return $this->login($request);
        } else {
            $url = $this->signOnService->getSSOLoginRedirectURL(route('login'));
            return Redirect::away($url);
        }
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, $this->signOnService->getSSOCallbackValidationRules($request));
    }

    protected function credentials(Request $request)
    {
        $credentialArray = $this->signOnService->credentialsFromRequest($request, route('login'));
        unset($credentialArray['password']);
        $request->merge($credentialArray);
        $id = $credentialArray['id'];
        return isset($id) ? ['id' => $id, 'password' => ''] : [];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->route('error_show',['id'=>401]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        return redirect()->route('error_show',['id'=>401, 'error'=>'Sorry! It seems you\'re trying that too often! Try again in a bit.']);
    }

    protected function sendLoginResponse(Request $request)
    {
        Session::forget('login_error');
        return $this->originalLoginResponse($request);
    }

}
