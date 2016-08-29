<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 12:17 AM
 */

namespace APOSite\ContractFramework\Requirements;

use APOSite\Models\Semester;
use APOSite\Models\Users\User;

abstract class MeetingBasedRequirement extends Requirement
{
    public final function getDetailsView(){
        return view('reports.meetinglist');
    }
}
