<?php

namespace APOSite\Http\Controllers\API;

use Illuminate\Http\Request;
use APOSite\Http\Controllers\Controller;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


}
