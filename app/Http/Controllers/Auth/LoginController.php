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

    /**
     * @param Request $request Current request
     * @return \Illuminate\Http\Response Either redirect to the SSO sign in page, or process the
     * return back to the sign-in page.
     */
    public function showLoginForm(Request $request)
    {
        if ($this->signOnService->isRequestFromSSOServiceCallback($request)) {
            return $this->login($request);
        } else {
            $url = $this->signOnService->getSSOLoginRedirectURL(route('login'));
            return Redirect::away($url);
        }
    }

    /**
     * Validates an incoming login request. This bootstraps to the SSO Service to validate the
     * request has whatever the Sign On Service needs to validate a login (e.g. a ticket). This
     * method is only entered into if the SSO Service believes that the current request could be
     * the callback (determined using SSOService#isRequestFromSSOServiceCallback).
     *
     * @param Request $request The current request being processed.
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, $this->signOnService->getSSOCallbackValidationRules($request));
    }

    /**
     * @param Request $request The callback request.
     * @return array An array of credentials containing an 'id' key and any other keys that might
     * be needed later by the SSO Service to validate the callback against the SSO Service. One
     * caveat is that the 'password' key cannot be used as this is reserved by Laravel's auth
     * system.
     */
    protected function credentials(Request $request)
    {
        $credentialArray = $this->signOnService->credentialsFromRequest($request, route('login'));
        $request->merge($credentialArray);
        $id = $credentialArray['id'];
        return isset($id) ? ['id' => $id, 'password' => ''] : [];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->to('401');
    }

    protected function sendLockoutResponse(Request $request)
    {
        Session::put('login_error', 'Sorry! It seems you\'re trying that too often! Try again 
        in a bit.');
        return redirect()->to('401');
    }

    protected function sendLoginResponse(Request $request)
    {
        Session::forget('login_error');
        return $this->originalLoginResponse($request);
    }


}
