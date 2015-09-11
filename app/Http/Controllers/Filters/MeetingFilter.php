<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 8/15/15
 * Time: 3:28 PM
 */

namespace APOSite\Http\Controllers\Filters;


use APOSite\Http\Controllers\Controller;
use APOSite\Models\Reports\Types\ChapterMeeting;

class MeetingFilter extends Controller{

    public function validateChapterMeeting($event){
        return $event instanceof ChapterMeeting;
    }

    public function validateExecMeeting($event){
        return $event instanceof ExecMeeting;
    }

    public function validatePledgeMeeting($event){
        return false;
    }

}