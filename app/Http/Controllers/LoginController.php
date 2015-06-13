<?php namespace APOSite\Http\Controllers;

use APOSite\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    public static function authenticate()
    {
        if (Session::has('username')) {
            return;
        } else if (Input::has('ticket')) {
            $userNameFromCas = LoginController::handleTicket(Input::get('ticket'), Request::url());
            Session::put('username', $userNameFromCas);
            if (User::find($userNameFromCas) != null) {
                return redirect(Request::url());
            } else {
                return view('errors.401')->with('message', 'You do not have permission to access this page.');
            }
        } else {
            return LoginController::directToAuthPage();
        }
    }

    private static function handleTicket($ticketVal, $serviceUrl)
    {
        $url = 'https://login.case.edu/cas/validate?ticket=' . $ticketVal . '&service=' . $serviceUrl;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = preg_split("/(\n|;)/", $output);
        if ($output [0] == 'yes') {
            return $output [1];
        } else {
            return null;
        }
    }

    public static function directToAuthPage()
    {
        return Redirect::away('https://login.case.edu/cas/login?service=' . Request::url());
    }

    /**
     * Authenticates the user.
     * Returns a username if the user is already authenticated, or redirects them to SSO if not.
     *
     * @return String with username or null.
     */
    public static function getCaseUsername()
    {
        if (Session::has('username')) {
            Log::info('User is successfully logged in. Username: ' . Session::get('username'));
            return Session::get('username');
        } else if (Input::has('ticket')) {
            $ticket = Input::get('ticket');
            $username = LoginController::handleTicket($ticket, Request::url());
            if ($username != null) {
                Session::put('username', $username);
                return Redirect::to(Request::url());
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public static function logout()
    {
        Session::forget('username');
        if (Session::has('debug_username')) {
            Session::forget('debug_username');
        }
    }

    public static function currentUser()
    {
        return User::find(Session::get('username'));
    }

}
