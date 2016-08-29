<?php

namespace APOSite\Http\Controllers;

use APOSite\ContractFramework\Contracts\ActiveContract;
use APOSite\ContractFramework\Contracts\AssociateContract;
use APOSite\ContractFramework\Contracts\PledgeContract;
use APOSite\ContractFramework\Requirements\ActiveMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\ActiveMemberTotalHoursRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\AssociateMemberInsideHoursRequirement;
use APOSite\ContractFramework\Requirements\BrotherhoodHoursRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberChapterMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberDuesRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberPledgeMeetingRequirement;
use APOSite\ContractFramework\Requirements\PledgeMemberTotalHoursRequirement;
use APOSite\Http\Requests\Reports\ViewContractProgressRequest;
use APOSite\Http\Requests\Reports\ViewStatisticsRequest;
use APOSite\Models\Contracts\Reports\Types\ServiceReport;
use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use Illuminate\Support\Facades\DB;

class ChapterStatisticsController extends Controller
{


    /**
     * ChapterStatisticsController constructor.
     */
    public function __construct()
    {
        $this->middleware('SSOAuth');
    }

    public function chapterStatistics(ViewStatisticsRequest $request)
    {
        if($request->has('semester')){
            $requestedSemester = Semester::find($request->get('semester'));
            if($requestedSemester != null){
                $semester = $requestedSemester;
            } else {
                $semester = Semester::currentSemester();
            }
        } else {
            $semester = Semester::currentSemester();
        }

        $totalInsideHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->whereProjectType('inside')->approved()->join('reports',
                    'report_type_id', '=', 'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);
        $totalOutsideHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->whereProjectType('outside')->approved()->join('reports',
                    'report_type_id', '=', 'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);
        $totalChapterHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->whereServiceType('chapter')->approved()->join('reports',
                    'report_type_id', '=', 'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);
        $totalCommunityHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->whereServiceType('community')->approved()->join('reports',
                    'report_type_id', '=', 'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);
        $totalCountryHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->whereServiceType('country')->approved()->join('reports',
                    'report_type_id', '=', 'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);
        $totalCampusHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->whereServiceType('campus')->approved()->join('reports',
                    'report_type_id', '=', 'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);
        $totalHours = round(DB::table('report_user')->whereIn('report_id',
                ServiceReport::inSemester($semester)->approved()->join('reports', 'report_type_id', '=',
                    'service_reports.id')->where('report_type_type',
                    ServiceReport::class)->select('reports.id')->lists('reports.id')->toArray())->sum('value') / 60, 2);

        $totalActiveContracts = User::activeForSemester($semester)->count();
        $totalPledgeContracts = User::pledgeForSemester($semester)->count();
        $totalAssociateContracts = User::associateForSemester($semester)->count();
        $totalNeophyteContracts = User::neophyteForSemester($semester)->count();

        $activeChapterMeetings = 0;
        $activePledgeMeetings = 0;
        $activeHours = 0;
        $activeDues = 0;
        $activeBrotherhoodHours = 0;
        $activesComplete = 0;

        $associateHours = 0;
        $associateDues = 0;
        $associateBrotherhoodHours = 0;
        $associatesComplete = 0;

        $pledgeChapterMeetings = 0;
        $pledgeHours = 0;
        $pledgeBrotherhoodHours = 0;
        $pledgePledgeMeetings = 0;
        $pledgeDues = 0;
        $pledgesComplete = 0;

        $allUsers = User::all();
        foreach ($allUsers as $user) {
            $contract = $user->contractForSemester($semester);
            if ($contract == null) {
                continue;
            }
            if ($contract instanceof ActiveContract) {
                if ($contract->isComplete()) {
                    $activesComplete++;
                    $activeChapterMeetings++;
                    $activePledgeMeetings++;
                    $activeHours++;
                    $activeDues++;
                    $activeBrotherhoodHours++;
                    continue;
                }
                $requirements = $contract->requirements;
                foreach ($requirements as $req) {
                    if ($req->isComplete()) {
                        if ($req instanceof ActiveMemberChapterMeetingRequirement) {
                            $activeChapterMeetings++;
                        } else {
                            if ($req instanceof ActiveMemberTotalHoursRequirement) {
                                $activeHours++;
                            } else {
                                if ($req instanceof ActiveMemberDuesRequirement) {
                                    $activeDues++;
                                } else {
                                    if ($req instanceof ActiveMemberPledgeMeetingRequirement) {
                                        $activePledgeMeetings++;
                                    } else {
                                        if ($req instanceof BrotherhoodHoursRequirement) {
                                            $activeBrotherhoodHours++;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                if ($contract instanceof AssociateContract) {
                    if ($contract->isComplete()) {
                        $associatesComplete++;
                        $associateHours++;
                        $associateDues++;
                        $associateBrotherhoodHours++;
                        continue;
                    }
                    $requirements = $contract->requirements;
                    foreach ($requirements as $req) {
                        if ($req->isComplete()) {
                            if ($req instanceof AssociateMemberInsideHoursRequirement) {
                                $associateHours++;
                            } else {
                                if ($req instanceof AssociateMemberDuesRequirement) {
                                    $associateDues++;
                                } else {
                                    if ($req instanceof BrotherhoodHoursRequirement) {
                                        $associateBrotherhoodHours++;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($contract instanceof PledgeContract) {
                        if ($contract->isComplete()) {
                            $pledgesComplete++;
                            $pledgeChapterMeetings++;
                            $pledgePledgeMeetings++;
                            $pledgeHours++;
                            $pledgeDues++;
                            $pledgeBrotherhoodHours++;
                            continue;
                        }
                        $requirements = $contract->requirements;
                        foreach ($requirements as $req) {
                            if ($req->isComplete()) {
                                if ($req instanceof PledgeMemberChapterMeetingRequirement) {
                                    $pledgeChapterMeetings++;
                                } else {
                                    if ($req instanceof PledgeMemberTotalHoursRequirement) {
                                        $pledgeHours++;
                                    } else {
                                        if ($req instanceof PledgeMemberDuesRequirement) {
                                            $pledgeDues++;
                                        } else {
                                            if ($req instanceof PledgeMemberPledgeMeetingRequirement) {
                                                $pledgePledgeMeetings++;
                                            } else {
                                                if ($req instanceof BrotherhoodHoursRequirement) {
                                                    $pledgeBrotherhoodHours++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return view('tools.statistics',
            compact('totalInsideHours', 'totalOutsideHours', 'totalChapterHours', 'totalCommunityHours',
                'totalCountryHours', 'totalCampusHours', 'totalHours', 'totalActiveContracts',
                'totalAssociateContracts', 'totalPledgeContracts', 'totalNeophyteContracts', 'activeChapterMeetings',
                'activePledgeMeetings',
                'activeHours',
                'activeDues',
                'activeBrotherhoodHours',
                'activesComplete',

                'associateHours',
                'associateDues',
                'associateBrotherhoodHours',
                'associatesComplete',

                'pledgeChapterMeetings',
                'pledgeHours',
                'pledgeBrotherhoodHours',
                'pledgePledgeMeetings',
                'pledgeDues',
                'pledgesComplete',
                'semester'));
    }

    public function contractStatusPage(ViewContractProgressRequest $request){
        $pledgeBrothers = User::PledgeForSemester(Semester::currentSemester())->orderBy('first_name','ASC')->orderBy('last_name','ASC')->get();
        if(AccessController::isMembership(LoginController::currentUser())){
            $activeBrothers = User::ActiveForSemester(Semester::currentSemester())->orderBy('first_name','ASC')->orderBy('last_name','ASC')->get();
            $associateBrothers = User::AssociateForSemester(Semester::currentSemester())->orderBy('first_name','ASC')->orderBy('last_name','ASC')->get();
            return view('tools.contractstatus')->with(compact('activeBrothers','associateBrothers','pledgeBrothers'));
        } else if (AccessController::isPledgeEducator(LoginController::currentUser())){
            return view('tools.contractstatus_pledges')->with(compact('pledgeBrothers'));
        } else {
            //Do something here if stuff is all messed up.
        }
    }
}