<?php

namespace APOSite\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use APOSite\Http\Controllers\LoginController;
use APOSite\Models\User;

class SSOAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $username = null;
        if (Session::has('username')) {
            $username = Session::get('username');
        } else if (Input::has('ticket')) {
            $username = LoginController::handleTicket(Input::get('ticket'), $request->url());
            Session::put('username', $username);
            return redirect($request->url());
        } else {
            return LoginController::directToAuthPage();
        }
        if (User::find($username) == null) {
            return view('errors.401')->with('message', 'You do not have permission to access this page.');
        } else {
            return $next($request);
        }
    }
}
