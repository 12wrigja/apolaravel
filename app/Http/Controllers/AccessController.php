<?php namespace APOSite\Http\Controllers;

class AccessController extends Controller
{

    public static function isWebmaster($user)
    {
        return static::officeIDsInArray($user, []);
    }

    public static function isTreasurer($user)
    {
        return static::officeIDsInArray($user, ['11']);
    }

    public static function isHistorian($user)
    {
        return static::officeIDsInArray($user, ['3']);
    }

    public static function isSergentAtArms($user)
    {
        return static::officeIDsInArray($user, ['13']);
    }

    public static function isPresident($user)
    {
        return static::officeIDsInArray($user, ['4']);
    }

    public static function isExecMember($user)
    {
        $ids = static::getOfficeIDs($user);
        return count($ids) > 0;
    }

    public static function isFellowship($user)
    {
        return static::officeIDsInArray($user, ['9', '8']);
    }

    public static function isMembership($user)
    {
        return static::officeIDsInArray($user, ['5', '18']);
    }

    public static function isPledgeEducator($user)
    {
        return static::officeIDsInArray($user, ['2', '10', '21']);
    }

    public static function isSecretary($user)
    {
        return static::officeIDsInArray($user, ['12']);
    }

    public static function isService($user)
    {
        return static::officeIDsInArray($user, ['6', '7']);
    }

    private static function getOfficeIDs($user)
    {
        return $user->offices()->current()->lists('id');
    }

    private static function officeIDsInArray($user, $ids = array())
    {
        if ($user == null) {
            return false;
        }
        //Inject the webmaster ids into the list
        $ids[] = 1;
        $ids[] = 27;
        foreach (static::getOfficeIDs($user) as $index => $id) {
            if (in_array($id, $ids)) {
                return true;
            }
        }
    }

}
