<?php

namespace APOSite\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = [
        'display_name',
        'email',
        'type',
        'display_order'
    ];
}
