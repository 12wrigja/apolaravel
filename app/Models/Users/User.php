<?php

namespace APOSite\Models\Users;

use APOSite\Models\Semester;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query;
use Illuminate\Support\Facades\App;
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
        return $this->getDisplayName() . " " . $this->last_name;
    }

    public function getDisplayName()
    {
        if ($this->nickname != null) {
            return $this->nickname;
        } else {
            return $this->first_name;
        }
    }

    public function reports()
    {
        return $this->belongsToMany('APOSite\Models\Contracts\Report')->withPivot('value', 'tag')->with('eventType');
    }

    public function contractForSemester($semester)
    {
        if ($semester == null) {
            $semester = Semester::currentSemester();
        }
        $contract_id = $this->ContractTypeForSemester($semester);
        try {
            return App::make('APOSite\ContractFramework\Contracts\\' . $contract_id . 'Contract',
                ['user' => $this, 'semester' => $semester]);
        } catch (\Exception $e) {
            return null;
        }

    }

    public function offices()
    {
        return $this->belongsToMany('APOSite\Models\Office')->withPivot('semester_id', 'alt_text');
    }

    public function pictureURL($size = 500)
    {
        return "http://www.gravatar.com/avatar/" . md5($this->picture) . "?s=$size&d=mm";
    }

    public function getPledgeSemesterAttribute($value)
    {
        return Semester::find($value);
    }

    public function getInitiationSemesterAttribute($value)
    {
        return Semester::find($value);
    }

    public function getGraduationSemesterAttribute($value)
    {
        return Semester::find($value);
    }

    public function fullDisplayName()
    {
        if ($this->first_name == $this->nickname || $this->nickname == null) {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->nickname . ' (' . $this->first_name . ') ' . $this->last_name;
        }
    }

    public function family()
    {
        return Family::find($this->family_id);
    }

    public function lifetimeHours()
    {
        return $this->reports()->ServiceReports()->sum('value');
    }

    public function scopeActiveForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->whereContractId('Active')->whereSemesterId($semester->id);
    }

    public function scopeAssociateForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->whereContractId('Associate')->whereSemesterId($semester->id);
    }

    public function scopePledgeForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->whereContractId('Pledge')->whereSemesterId($semester->id);
    }

    public function scopeNeophyteForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->whereContractId('Neophyte')->whereSemesterId($semester->id);
    }

    public function ContractTypeForSemester(Semester $semester)
    {
        $query = DB::table('contract_user')->where('user_id', $this->id);
        if ($semester == null) {
            $semester = Semester::currentSemester();
        }
        $query = $query->where('semester_id', $semester->id);
        $contract = $query->select('contract_id')->first();
        if ($contract == null) {
            return null;
        } else {
            return $contract->contract_id;
        }
    }

    public function isPledge($semester = null)
    {
        return $this->contractForSemester($semester) == "Pledge";
    }

    public function isActive($semester = null)
    {
        return $this->contractForSemester($semester) == "Active";
    }

    public function isAssociate($semester = null)
    {
        return $this->contractForSemester($semester) == "Associate";
    }
}
