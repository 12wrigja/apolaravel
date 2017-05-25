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
       $this->command->error('DuesSeeder not implemented.'); 
    }
}
