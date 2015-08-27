<?php namespace APOSite\Http\Controllers;

use APOSite\Models\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

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
        return Redirect::away('https://login.case.edu/cas/login?service=' . Request::url());
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
        if(Session::has('user') && Session::get('user') != null){
            return Session::get('user');
        } else {
            $user = User::find(Session::get('username'));
            Session::put('user',$user);
            return $user;
        }
    }

}
