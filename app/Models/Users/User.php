<?php namespace APOSite\Models;

use APOSite\Http\Controllers\AccessController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'nickname',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'zip_code',
        'campus_residence',
        'biography',
        'join_reason',
        'major',
        'minor',
        'graduation_semester',
        'hometown'
    ];

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

    public function contracts(){
        return $this->belongsToMany('APOSite\Models\Contract')->withPivot('semester_id');
    }

    public function currentContract() {
        return $this->contracts()->orderBy('semester_id','DESC')->first();
    }
}
