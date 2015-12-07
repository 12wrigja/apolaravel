<?php

namespace APOSite\Http\Controllers;

use Illuminate\Http\Request;

use APOSite\Http\Requests;
use APOSite\Http\Controllers\Controller;

class GrilledCheeseController extends Controller
{
    /**
     * @inheritDoc
     */
    function __construct()
    {
        $this->middleware('SSOAuth',['only'=>'showManagementPage']);
    }

    public function showOrderPage(){
        return view('grilledcheese.order');
    }

    public function showManagementPage(){
        return redirect('https://docs.google.com/spreadsheets/d/1MpUXJquPOapz6Kr2Ow187S5TRXc8xpXjrMZQGkYsyH4/edit#gid=1050114767&vpid=A2');
    }

}
