<?php

namespace APOSite\Http\Controllers\Auth;

use APOSite\Interfaces\SSOService;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;

class CaseSSOService implements SSOService
{
    protected $guzzle;

    public function __construct(Guzzle $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    public function getSSOCallbackValidationRules(Request $request)
    {
        return [
            'ticket' => 'required'
        ];
    }

    public function credentialsFromRequest(Request $request, $redirectBackRoute)
    {
        $url = 'https://login.case.edu/cas/validate?ticket=' . $request->get('ticket') . '&service=' . $redirectBackRoute;
        $output = $this->guzzle->get($url)->getBody();
        $output = preg_split("/(\n|;)/", $output);
        $username = null;
        if ($output [0] == 'yes') {
            $username = $output [1];
        }
        return ['id' => $username];
    }

    public function getSSOLoginRedirectURL($redirectBackRoute)
    {
        return 'https://login.case.edu/cas/login?service=' . $redirectBackRoute;
    }

    /**
     * @param Request $request The current request being processed.
     * @return True if this request came from this SSO Service and should be used to validate a
     * login request.
     */
    public function isRequestFromSSOServiceCallback(Request $request)
    {
        return $request->has('ticket');
    }
}
