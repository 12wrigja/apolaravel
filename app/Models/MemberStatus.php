<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class MemberStatus extends Model {
	
	protected $table = 'tblstatus';
	
	protected $primarykey = 'id';
	
	public $timestamps = false;
	
}