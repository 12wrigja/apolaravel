<?php

class CarouselItems extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'homepage_carousel';
	
	protected $primaryKey = 'id';
	
	public $timestamps = false;

}
