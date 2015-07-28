<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'display_name',
        'email',
        'type',
        'display_order'
    ];

    public function scopeCurrent($query){
        $pivot = $this->users()->getTable();
        return $query->where($pivot.'.semester_id',Semester::currentSemester()->id);
    }

    public function users(){
        return $this->belongsToMany('APOSite\Models\User')->withPivot('semester_id','alt_text');
    }

    public function currentOfficer(){
        return $this->users()->where('semester_id',Semester::currentSemester()->id)->get();
    }
}
