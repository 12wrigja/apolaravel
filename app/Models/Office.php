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

    //Warning: Only to be used
    public function scopeCurrent($query)
    {
        $pivot = $this->users()->getTable();
        return $query->where($pivot . '.semester_id', Semester::currentSemester()->id);
    }

    public function scopeForSemester($query, $semesterID){
        $pivot = $this->users()->getTable();
        return $query->where($pivot . '.semester_id', $semesterID);
    }

    public function users()
    {
        return $this->belongsToMany('APOSite\Models\Users\User')->withPivot('semester_id', 'alt_text');
    }

    public function currentOfficer()
    {
        return $this->users()->orderBy('semester_id','DESC')->first();
    }

    public function scopeAllInOrder($query){
        return $query->orderBy('display_order','ASC');
    }

    public function scopeActive($query){
        return $query->whereActive(true);
    }
}
