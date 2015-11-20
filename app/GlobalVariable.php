<?php

namespace APOSite;

use Illuminate\Database\Eloquent\Model;

class GlobalVariable extends Model
{
    protected $fillable = ['key','value'];

    protected $primaryKey = 'key';

    public $timestamps = false;

    public static function ContractSigning(){
        $object = static::find('contract_signing')->first();
        $object->value = ($object->value == "1");
        return  $object;
    }

    public static function ShowInactive(){
        $object = static::find('showInactive')->first();
        $object->value = ($object->value == "1");
        return  $object;
    }
}
