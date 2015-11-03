<?php namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselItem extends Model
{

    protected $fillable = ['title', 'caption', 'action_text', 'action_url'];

    protected $primaryKey = 'id';

    public function image()
    {
        return $this->hasOne('APOSite\Models\ImageEntry', 'id', 'background_image');
    }

}
