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
        'hometown',
        'family_id'
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

    public function offices(){
        return $this->belongsToMany('APOSite\Models\Office')->withPivot('semester_id','alt_text');
    }

    public function pictureURL($size = 500){
            return "http://www.gravatar.com/avatar/" . md5($this->picture) . "?s=$size&d=mm";
    }

    public function getPledgeSemesterAttribute($value){
        return Semester::find($value);
    }

    public function getInitiationSemesterAttribute($value){
        return Semester::find($value);
    }

    public function getGraduationSemesterAttribute($value){
        return Semester::find($value);
    }

    public function fullDisplayName(){
        if($this->first_name == $this->nickname || $this->nickname == null){
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->nickname . ' (' . $this->first_name . ') ' . $this->last_name;
        }
    }

    public function family(){
        return Family::find($this->family_id);
    }

}
