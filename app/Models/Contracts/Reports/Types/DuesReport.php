<?php

namespace APOSite\Models\Contracts\Reports\Types;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Transformers\ChapterMeetingTransformer;
use APOSite\Models\Contracts\Reports\BaseModel;
use APOSite\Models\Users\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use League\Fractal\Manager;
use APOSite\ContractFramework\Requirements\ActiveMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;

class DuesReport extends BaseModel
{

    protected $fillable = ['report_date','creator_id'];
    protected $dates = ['report_date','created_at','updated_at','deleted_at'];

    public function transformer(Manager $manager)
    {
        //TODO fix transformer
        return new ChapterMeetingTransformer($manager);
    }

    public function computeValue(array $brotherData)
    {
        if(array_key_exists('type',$brotherData)){
            if($brotherData['type'] == 'full'){
                $brother = User::find($brotherData['id']);
                $contract = $brother->contractForSemester(null);
                $requirements = $contract->requirements;
                $duesReq = null;
                $requirements = $contract->requirements;
                foreach ($requirements as $requirement) {
                    if ($requirement instanceof ActiveMemberDuesRequirement || $requirement instanceof AssociateMemberDuesRequirement || $requirement instanceof PledgeMemberDuesRequirement) {
                        $duesReq = $requirement;
                        break;
                    }
                }
                if($duesReq != null){
                    return $duesReq->getThreshold();
                } else {
                    Log::error('Unable to log user '.$brother->id.' paying full dues.');
                    //TODO insert a way to notify the webmaster when this happens so that he can look into it.
                }
            }
        } else {
            return $brotherData['value'];
        }
    }

    public function getTag(array $brotherData)
    {
        return null;
    }

    public function createRules()
    {
        $rules = [
            //Rules for the core report data
            'report_date' => ['required', 'date'],
            'brothers' => ['required', 'array']
        ];
        $extraRules = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
                $extraRules['brothers.'.$index.'.type'] = ['sometimes','required','in:full,other'];
                $extraRules['brothers.' . $index . '.value'] = ['required','integer','min:0'];
            }
        }
        $newRules = array_merge($rules, $extraRules);
        return $newRules;
    }

    public function updateRules()
    {
        //TODO make sure that we don't need to update dues reports
//        $rules = [
//            //Rules for the core report data
//            'minutes' => ['sometimes', 'required', 'min:40'],
//            'event_date' => ['sometimes','required', 'date'],
//            'brothers' => ['sometimes','required', 'array']
//        ];
//        $extraRules = [];
//        if (Request::has('brothers')) {
//            foreach (Request::get('brothers') as $index => $brother) {
//                $extraRules['brothers.' . $index . '.id'] = ['required', 'exists:users,id'];
//                $extraRules['brothers.' . $index . '.count_for'] = ['sometimes','required','in:chapter,pledge,exec'];
//            }
//        }
//        $newRules = array_merge($rules, $extraRules);
//        return $newRules;
        return [];

    }

    public function errorMessages()
    {
        $extraMessages = [];
        if (Request::has('brothers')) {
            foreach (Request::get('brothers') as $index => $brother) {
                $extraMessages['brothers.' . $index . '.id.exists'] = 'The cwru id :input is not valid.';
            }
        }
        return $extraMessages;
    }

    public function canStore(User $user)
    {
        return AccessController::isTreasurer($user);
    }

    public function canManage(User $user){
        return AccessController::isTreasurer($user);
    }

    public static function applyRowLevelSecurity(QueryBuilder $query, User $user)
    {
        return $query;
        // TODO: Implement applyRowLevelSecurity() method.
    }

    public static function applyReportFilters(QueryBuilder $query)
    {
        return $query;
    }

    public function canUpdate(User $user)
    {
        return false;
    }

    public function canRead(User $user)
    {
        return $user != null;
    }

    public function updatable()
    {
        //TODO check and see if we need to update dues reports
        return [];
//        return ['event_date', 'brothers'];
    }
}
