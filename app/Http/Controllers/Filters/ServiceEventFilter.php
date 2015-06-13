<?php

namespace APOSite\Http\Controllers\Filters;


use APOSite\Http\Controllers\Controller;

class ServiceEventFilter extends Controller{

    public function validateServiceEvent($user, $event){
        return $user->id;
    }

}