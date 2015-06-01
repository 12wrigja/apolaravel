<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Officers extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tblofficers';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;

    public function CurrentUser(){
        return $this->belongsTo('APOSite\Models\User','CurrentOfficer');
    }

    public function NewUser(){
        return $this->belongsTo('APOSite\Models\User','NewlyElectedOfficer');
    }

    public static function AllInOrder(){
        return Officers::where('currentOfficer','!=','')->orderBy('displayOrder')->get();
    }

}
