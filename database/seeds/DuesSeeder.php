<?php

use Illuminate\Database\Seeder;
use APOSite\Models\Contracts\Reports\Types\DuesReport;
use Carbon\Carbon;
use APOSite\Models\Users\User;
use APOSite\ContractFramework\Requirements\ActiveMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberDuesRequirement;
use APOSite\ContractFramework\Contracts\NeophyteContract;
use APOSite\Models\Contracts\Report;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;

class DuesSeeder extends Seeder
{
    public function run()
    {
        $duesMap = DB::connection('apo')->table('tblcontracts')->where('paidDues',1)->select('id as user_id')->get();
        $report = new DuesReport();
        $report->creator_id = 'jow5';
        $report->report_date = Carbon::now();
        $report->save();
        $core = new Report();
        $report->core()->save($core);
        foreach($duesMap as $index=>$map){
            $user = User::find($map->user_id);
            if($user != null) {
                $contract = $user->contractForSemester(null);
                if ($contract != null) {
                    $duesReq = null;
                    $requirements = $contract->requirements;
                    foreach ($requirements as $requirement) {
                        if ($requirement instanceof ActiveMemberDuesRequirement || $requirement instanceof AssociateMemberDuesRequirement || $requirement instanceof PledgeMemberDuesRequirement) {
                            $duesReq = $requirement;
                            break;
                        }
                    }
                    if ($duesReq != null) {
                        $report->core->linkedUsers()->attach($user, ['value' => $duesReq->getThreshold(), 'tag' => null]);
                    } else if (!($contract instanceof NeophyteContract)){
                        $this->command->error('Unable to add user ' . $user->id . ' to dues report. Contract: '.get_class($contract));
                    }
                }
            }
        }
    }
}
