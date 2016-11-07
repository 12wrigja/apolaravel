<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 12:17 AM
 */

namespace APOSite\ContractFramework\Requirements;

abstract class DuesBaseRequirement extends Requirement
{
    public final function getDetailsView()
    {
        return view('reports.duesreports.dueseventlist');
    }
}
