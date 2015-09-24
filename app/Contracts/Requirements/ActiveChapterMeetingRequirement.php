<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 9/24/15
 * Time: 7:40 AM
 */

namespace APO\Contracts\Requirements;


class ActiveChapterMeetingRequirement extends Requirement{
    protected $threshold = 8;
    protected $comparison = GT;

    public function isComplete(){

    }
}