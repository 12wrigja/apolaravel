<?php namespace APOSite\Http\Controllers;

use APOSite\Models\Users\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public static function handleTicket($ticketVal, $serviceUrl)
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
        if (Request::has('redirect_url')) {
            session(['redirect_url' => Request::get('redirect_url')]);
        }
        $url = 'https://login.case.edu/cas/login?service=' . Request::url();
        if (Request::wantsJson()) {
            return Response::json(['error' => ['redirect_url' => $url,]], 401);
        } else {
            return Redirect::away($url);
        }
    }

    public static function logout()
    {
        Session::forget('user');
        Session::forget('username');
        if (Session::has('debug_username')) {
            Session::forget('debug_username');
        }
    }

    public static function currentUser()
    {
        if (Session::has('user') && Session::get('user') != null) {
            return Session::get('user');
        } else {
            $user = User::find(Session::get('username'));
            Session::put('user', $user);
            return $user;
        }
    }

    public static function debugLogin()
    {
        $username = Input::get('username');
        if (App::environment() == 'local') {
            Session::put('username', $username);
            return Response::JSON(['newUsername' => $username]);
        } else {
            return 'Invalid session.';
        }
    }

}
