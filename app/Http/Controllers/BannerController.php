<?php

namespace APOSite\Http\Controllers;

use Illuminate\Http\Request;

class BannerController extends Controller
{

    /**
     * BannerController constructor.
     */
    public function __construct()
    {
        $this->middleware('SSOAuth');
    }

    public function index(Request $request){
        return view('tools.banner.bannermanagement');
    }

}
