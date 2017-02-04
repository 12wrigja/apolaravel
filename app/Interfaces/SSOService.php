<?php

namespace APOSite\Interfaces;

use Illuminate\Http\Request;

interface SSOService
{
    /**
     * @param Request $request The current request being processed.
     * @return True if this request came from this SSO Service and should be used to validate a
     * login request.
     */
    public function isRequestFromSSOServiceCallback(Request $request);

    /**
     * @param Request $request The current request being processed.
     * @return array array of validation rules
     */
    public function getSSOCallbackValidationRules(Request $request);

    /**
     * @param Request $request The current request being processed.
     * @param $redirectBackRoute string the route which was used to redirect back to the this app.
     * @return mixed
     */
    public function credentialsFromRequest(Request $request, $redirectBackRoute);

    /**
     * @param $redirectBackRoute string the route which will be used to redirect back to this app.
     * @return string the URL to redirect to, which should take end-users to the SSO Sign In page.
     */
    public function getSSOLoginRedirectURL($redirectBackRoute);
}

