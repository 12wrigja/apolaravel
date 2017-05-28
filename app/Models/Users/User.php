<?php

namespace APOSite\Models\Users;

use APOSite\ContractFramework\Contracts\Contract;
use APOSite\GlobalVariable;
use APOSite\Models\Semester;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\HasApiTokens;
use Symfony\Component\HttpKernel\Exception\HttpException;


class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens;
    use SoftDeletes;
    use Notifiable;
    use Authenticatable, Authorizable;

    // BEGIN Authorization Changes

    // Setup the primary key as non-incrementing - it's a user's CWRU ID, which is not a number.
    public $incrementing = false;

    // Set their internal Auth password as nothing. Auth is handled by SSO - we simply need to check the tickets upon
    // return. See LoginController for details.
    public function getAuthPassword()
    {
        return bcrypt('');
    }

    // Disable remember me functionality. We don't rename the remember me token functionality because who knows where
    // else this is used....
    public function getRememberToken()
    {
        return null; // Using Remember Me is not supported on this site;
    }

    public function setRememberToken($value)
    {
        return null; // Using Remember Me is not supported on this site;
    }

    public function setAttribute($key, $value)
    {
        $isRememberMeTokenAttribute = ($key == $this->getRememberTokenName());
        if (!$isRememberMeTokenAttribute) {
            return parent::setAttribute($key, $value);
        }
        return $this;
    }

    // END Authorization Changes

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

    // Attributes that are to be cast into Carbon Dates
    protected $dates = ['created_at','updated_at','deleted_at'];

    // Attributes that are to be appended to JSON representations of these models.
    protected $appends = ['contract', 'family'];

    // Attributes that are renamed internally to be something else.
    protected $interallyRenamed = ['contract' => 'contract_id'];

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
        })->where('contract_id', 'LIKE', 'Active%')->whereSemesterId($semester->id);
    }

    public function scopeAssociateForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->where('contract_id', 'LIKE', 'Associate%')->whereSemesterId($semester->id);
    }

    public function scopePledgeForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->where('contract_id', 'LIKE', 'Pledge%')->whereSemesterId($semester->id);
    }

    public function scopeNeophyteForSemester($query, Semester $semester)
    {
        return $query->join('contract_user', function ($join) {
            $join->on('users.id', '=', 'contract_user.user_id');
        })->where('contract_id', 'LIKE', 'Neophyte%')->whereSemesterId($semester->id);
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
        if ($semester == null) {
            $semester = Semester::currentSemester();
        }
        return $this->ContractTypeForSemester($semester) == "Pledge";
    }

    public function isActive($semester = null)
    {
        if ($semester == null) {
            $semester = Semester::currentSemester();
        }
        return $this->ContractTypeForSemester($semester) == "Active";
    }

    public function isAssociate($semester = null)
    {
        if ($semester == null) {
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

    public function scopeMatchAllAttributes($query, $attributes)
    {
        $appendedFilterable = [];
        foreach ($attributes as $key => $value) {
            if (in_array($key, $this->getFilterableAttributes())) {
                if (in_array($key, $this->appends)) {
                    $appendedFilterable[$key] = $value;
                } else {
                    if ($value == 'null') {
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

    public function validateSearchAttributes($attributes)
    {
        $invalidAttributes = [];
        foreach ($attributes as $key) {
            //Test to make sure that all the attributes are valid.
            if (!in_array($key, $this->getFilterableAttributes())) {
                array_push($invalidAttributes, 'Attribute ' . $key . ' is not a valid attribute.');
            }
        }
        if (count($invalidAttributes) > 0) {
            $e = new ValidationException(422, join(PHP_EOL, $invalidAttributes));
            throw $e;
        } else {
            return $attributes;
        }
    }

    public function getFilterableAttributes()
    {
        return array_merge($this->fillable, $this->appends, ['big']);
    }

    public function getFamilyAttribute()
    {
        return Family::find($this->family_id);
    }

    public function serializeBigAttribute()
    {
        $big = User::find($this->big);
        if ($big == null) {
            return null;
        } else {
            return [
                'id' => $big->id,
                'fist_name' => $big->first_name,
                'last_name' => $big->last_name,
                'display_name' => $big->fullDisplayName()
            ];
        }
    }
}
