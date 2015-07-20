<?php namespace APOSite\Models;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    public function getFullDisplayName()
    {
        return $this->getDisplayName() . " " . $this->lastName;
    }

    public function getDisplayName()
    {
        if ($this->nickName != null) {
            return $this->nickName;
        } else {
            return $this->firstName;
        }
    }

    public function reports(){
        return $this->belongsToMany('APOSite\Models\Report')->withPivot('value');
    }
}
