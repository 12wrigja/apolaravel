<?php

namespace APOSite\Http\Controllers;

use APOSite\Http\Requests;
use Illuminate\Http\Request;

class GrilledCheeseController extends Controller
{
    /**
     * @inheritDoc
     */
    function __construct()
    {
        $this->middleware('SSOAuth', ['only' => 'showManagementPage']);
    }

    public function showOrderPage()
    {
        return view('grilledcheese.order');
    }

    public function showManagementPage()
    {
        return redirect('https://docs.google.com/spreadsheets/d/1MpUXJquPOapz6Kr2Ow187S5TRXc8xpXjrMZQGkYsyH4/edit?usp=sharing');
    }

}
