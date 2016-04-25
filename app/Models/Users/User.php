<?php

namespace APOSite\Models\Users;

use APOSite\GlobalVariable;
use APOSite\Models\Semester;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use APOSite\ContractFramework\Contracts\Contract;

class User extends Model
{

    use SoftDeletes;

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
        'family_id',
        'big',
        'pledge_semester',
        'initiation_semester'
    ];
    protected $dates = ['deleted_at'];
    protected $appends = ['contract','family'];
    protected $interallyRenamed = ['contract'=>'contract_id'];

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
        if ($contract_id != null || $contract_id != "") {
            try {
                return App::make(Contract::ContractHome . $contract_id . 'Contract',
                    ['user' => $this, 'semester' => $semester]);
            } catch (\Exception $e) {
            }
        }
        return null;
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

    public function scopeIncludeContract($query)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        });
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
            //If this is null, we should see if they have been assigned as an alumni
            $alumContract = DB::table('contract_user')->where('user_id', $this->id)->orderBy('semester_id',
                'DESC')->first();
            if ($alumContract != null && ($alumContract->contract_id == "Alumni" || $alumContract->contract_id == "Adviser")) {
                return $alumContract->contract_id;
            }
            if (GlobalVariable::ShowInactive()->value) {
                return "Inactive";
            } else {
                return null;
            }
        } else {
            return $contract->contract_id;
        }
    }

    public function isPledge($semester = null)
    {
        if($semester == null){
            $semester = Semester::currentSemester();
        }
        return $this->ContractTypeForSemester($semester) == "Pledge";
    }

    public function isActive($semester = null)
    {
        if($semester == null){
            $semester = Semester::currentSemester();
        }
        return $this->ContractTypeForSemester($semester) == "Active";
    }

    public function isAssociate($semester = null)
    {
        if($semester == null){
            $semester = Semester::currentSemester();
        }

        return $this->ContractTypeForSemester($semester) == "Associate";
    }

    public function changeContract($newContract)
    {
        //Contract signing is enabled. Sign the given contract for the current semester
        //Check and see if they have already signed a contact for this semester:
        $user = $this->id;
        $sem = Semester::currentSemester();
        $existing = DB::table('contract_user')->where('user_id', $user)->where('semester_id',
            $sem->id)->select('contract_id')->get();
        if (count($existing) > 0) {
            try {
                DB::table('contract_user')->where('user_id', $user)->where('semester_id',
                    $sem->id)->update(['contract_id' => $newContract]);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            try {
                DB::table('contract_user')->insert([
                    'contract_id' => $newContract,
                    'user_id' => $user,
                    'semester_id' => $sem->id
                ]);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
    }

    public function getContractAttribute()
    {
        return $this->ContractTypeForSemester(Semester::currentSemester());
    }

    public function scopeMatchDatabaseAttributes($query, $attributes)
    {
        $appendedFilterable = [];
        foreach ($attributes as $key => $value) {
            if (!in_array($key, $this->hidden)) {
                if (in_array($key, $this->fillable)) {
                    $query = $query->where($key, $value);
                } else {
                    if (in_array($key, $this->appends)) {
                        $appendedFilterable[$key] = $value;
                    }
                }
            }
        }
        return $query;
    }

    public function scopeMatchAllAttributes($query, $attributes)
    {
        $appendedFilterable = [];
        foreach ($attributes as $key => $value) {
            if (in_array($key,$this->getFilterableAttributes())) {
                if (in_array($key, $this->appends)) {
                    $appendedFilterable[$key] = $value;
                } else {
                    if($value == 'null'){
                        $query = $query->whereNull($key);
                    } else {
                        $query = $query->where($key, $value);
                    }
                }
            }
        }
        $users = $query->get();
        foreach ($appendedFilterable as $key => $value) {
            $users = $users->filter(function ($obj) use ($key, $value) {
                return $obj->$key == $value;
            });
        }
        return $users;
    }

    public function validateAttributes($attributes)
    {
        foreach ($attributes as $key) {
            //Test to make sure that all the attributes are valid.
            if (!in_array($key, $this->getFilterableAttributes())) {
                $e = new HttpException(422, 'Attribute ' . $key . ' is not a valid attribute.');
                throw $e;
            }
        }
    }

    public function getValidSearchAttributeKeys($attributes)
    {
        foreach ($attributes as $key) {
            //Test to make sure that all the attributes are valid.
            if (!in_array($key, $this->getFilterableAttributes())){
                unset($attributes[$key]);
            }
        }
        return array_keys($attributes);
    }

    public function getFilterableAttributes(){
        return array_merge($this->fillable, $this->appends, ['big']);
    }

    public function getFamilyAttribute(){
        return Family::find($this->family_id);
    }

    public function serializeBigAttribute(){
        $big = User::find($this->big);
        if($big == null){
            return null;
        } else {
            return [
                'id'=>$big->id,
                'fist_name'=>$big->first_name,
                'last_name'=>$big->last_name,
                'display_name'=>$big->fullDisplayName()
        ];
        }
    }
}
