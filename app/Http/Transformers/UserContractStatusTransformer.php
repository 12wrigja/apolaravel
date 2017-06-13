<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 7/16/15
 * Time: 10:38 PM
 */

namespace APOSite\Http\Transformers;

use APOSite\ContractFramework\Contracts\Contract;
use Illuminate\Support\Str;
use League\Fractal\TransformerAbstract;

class UserContractStatusTransformer extends TransformerAbstract
{

    public function transform(Contract $contract)
    {
        $base = [
            'name' => $contract::$name,
            'description' => $contract::$description,
            'semester_id' => $contract->getSemesterID(),
            'is_complete' => $contract->isComplete(),
        ];
        $reqData = [];
        $sortedReqs = $contract->requirements->sortBy(function ($requirement) {
            return $requirement::$name;
        });
        foreach ($sortedReqs as $requirement) {
            $reqData[] = [
                'name' => $requirement::$name,
                'description' => $requirement::$description,
                'threshold' => $requirement->getThreshold(),
                'comparison' => $requirement->getComparison(),
                'value'=> $requirement->getValue(),
                'pending_value'=>$requirement->getPendingValue(),
                'is_complete'=>$requirement->isComplete(),
                'percent_complete'=>$requirement->getPercentDone(),
            ];
        }
        $base['requirements'] = $reqData;
        $base['misc_requirements'] = $contract::getOtherSigningRequirements();
        return $base;
    }

}