<?php

namespace APOSite\Http\Middleware;

use APOSite\Http\Controllers\AccessController;
use APOSite\Models\Users\User;
use Closure;
use Illuminate\Support\Facades\Session;

class UserSpoofingMiddleware
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
        //Setup data
        $spoofUserID = $request->get('spoof');
        $spoofingUser = User::find(Session::get('spoofusername'));
        $currentUser = User::find(Session::get('username'));
        if ($spoofingUser == null && !AccessController::isWebmaster($currentUser)) {
            Session::forget('spoofusername');
            $request->merge(['spoof' => null]);
            return $next($request);
        }
        if ($spoofingUser != null) {
            if (!AccessController::isWebmaster($spoofingUser)) {
                Session::flush();
                return \Redirect::route('home');
            } else {
                //Spoofer is the webmaster
                //If there is a name there, use that so long as it isn't the word Off.
                if($spoofUserID != null){
                    if($spoofUserID == 'off'){
                        $request = $this->setSpoofing($spoofingUser->id,$request);
                        Session::forget('spoofusername');
                    } else {
                        $request = $this->setSpoofing($spoofUserID,$request);
                    }
                }
                return $next($request);
            }
        } else {
            if (AccessController::isWebmaster($currentUser)) {
                //Start spoofing
                Session::put('spoofusername', $currentUser->id);
                $request = $this->setSpoofing($spoofUserID, $request);
                return $next($request);
            }
        }
    }

    private function setSpoofing($username,$request)
    {
        $user = User::find($username);
        if ($user != null) {
            Session::put('username', $username);
            Session::put('user', $user);
            $menuItemAdding = new AddUserMenuItems();
            $newRequest = $menuItemAdding->handle($request,function($request){
                return $request;
            });
            return $newRequest;
        }
    }
}
