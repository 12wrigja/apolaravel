<?php
class AccessController extends Controller {
	
	public static function retrieveUsersOfGroup($groupName){
		return DB::table('groups')
		->join('group_members','group_members.group_id','=','groups.id')
		->select('group_members.case_id')->where('groups.name','=',$groupName)->lists('case_id');
	}
	
	public static function retrieveAllGroupAssignments(){
		return DB::table('groups')
		->join('group_members','group_members.group_id','=','groups.id')
		->join('tblmembers','tblmembers.cwruID','=','group_members.case_id')
		->select('group_members.case_id','tblmembers.firstName','tblmembers.lastName','groups.name')->get();
		
	}
	public static function isWebmaster($username){
		return AccessController::isMemberOfGroup($username, 'webmaster');
	}
	
	public static function isTreasurer($username){
		return AccessController::isMemberOfGroup($username, 'treasurer');
	}
	
	public static function isHistorian($username){
		return AccessController::isMemberOfGroup($username, 'historian');
	}
	
	public static function isSergentAtArms($username){
		return AccessController::isMemberOfGroup($username, 'sergent_at_arms');
	}
	
	public static function isPresident($username){
		return AccessController::isMemberOfGroup($username, 'president');
	}
	
	public static function isExecMember($username){
		return AccessController::isMemberOfGroup($username, 'exec');
	}
	
	public static function isFellowship($username){
		return AccessController::isMemberOfGroup($username, 'fellowship');
	}
	
	public static function isMembership($username){
		return AccessController::isMemberOfGroup($username, 'membership');
	}
	
	public static function isPledgeEducator($username){
		return AccessController::isMemberOfGroup($username, 'pledge_educator');
	}
	
	public static function isSecretary($username){
		return AccessController::isMemberOfGroup($username, 'secretary');
	}
	
	public static function isService($username){
		return AccessController::isMemberOfGroup($username, 'service');
	}
	
	
	public static function isMember($username){
		return User::find($username) != null;
	}
	
	private static function isMemberOfGroup($username,$groupName){
		$groupies = AccessController::retrieveUsersOfGroup($groupName);
		if(in_array($username, $groupies)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
