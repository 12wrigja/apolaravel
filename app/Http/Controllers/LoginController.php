<?php
class LoginController extends Controller {
	
	/**
	 * Authenticates the user.
	 * Returns a username if the user is already authenticated, or redirects them to SSO if not.
	 *
	 * @return String with username or null.
	 */
	public static function getCaseUsername() {
		if (Session::has ( 'username' )) {
			Log::info('User is successfully logged in. Username: '.Session::get('username'));
			return Session::get ( 'username' );
		} else if (Input::has ( 'ticket' )) {
			$ticket = Input::get ( 'ticket' );
			$username = LoginController::handleTicket ( $ticket, Request::url () );
			if ($username != null) {
				Session::put ( 'username', $username );
				return $username;
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	
	public static function directToAuthPage(){
        return Redirect::away('https://login.case.edu/cas/login?service='.Request::url());
	}
	
	public static function debugLogin(){
		$username = Input::get('debug_username');
		if(null != $username){
			Session::put('username',$username);
		}
	}
	
	private static function handleTicket($ticketVal, $serviceUrl) {
		$url = 'https://login.case.edu/cas/validate?ticket=' . $ticketVal . '&service=' . $serviceUrl;
		$ch = curl_init ( $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec ( $ch );
		curl_close ( $ch );
		$output = preg_split ( "/(\n|;)/", $output );
		if ($output [0] == 'yes') {
			return $output [1];
		} else {
			return null;
		}
		return $output;
	}
	
	public static function logout(){
		Session::forget('username');
		if(Session::has('debug_username')){
			Session::forget('debug_username');
		}
	}
	
	public static function currentUser(){
		return User::find(Session::get('username'));
	}

	public static function validateTicket(){

	}

	public static function refresh(){

	}
}
