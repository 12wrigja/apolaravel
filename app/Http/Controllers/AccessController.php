<?php namespace APOSite\Http\Controllers;

use APOSite\Models\Users\User;
use APOSite\Models\Office;

class AccessController extends Controller
{

    public static function isWebmaster(User $user = null)
    {
        return static::officeIDsInArray($user, []);
    }

    public static function isTreasurer(User $user = null)
    {
        return static::officeIDsInArray($user, ['11']);
    }

    public static function isHistorian(User $user = null)
    {
        return static::officeIDsInArray($user, ['3']);
    }

    public static function isSergentAtArms(User $user = null)
    {
        return static::officeIDsInArray($user, ['13']);
    }

    public static function isPresident(User $user = null)
    {
        return static::officeIDsInArray($user, ['4']);
    }

    public static function isExecMember(User $user = null)
    {
        $ids = static::getOfficeIDs($user);
        return count($ids) > 0;
    }

    public static function isFellowship(User $user = null)
    {
        return static::officeIDsInArray($user, ['9', '8']);
    }

    public static function isMembership(User $user = null)
    {
        return static::officeIDsInArray($user, ['5', '18']);
    }

    public static function isPledgeEducator(User $user = null)
    {
        return static::officeIDsInArray($user, ['2', '10', '21']);
    }

    public static function isSecretary(User $user = null)
    {
        return static::officeIDsInArray($user, ['12']);
    }

    public static function isService(User $user = null)
    {
        return static::officeIDsInArray($user, ['6', '7']);
    }

    private static function getOfficeIDs(User $user = null)
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

    public static function getAccessibleFoldersForUser(User $user = null){
        $folders = [];
        if($user != null){
            if(static::isWebmaster($user)){
                $folders = [];
                $offices = Office::all()->lists('display_name');
                foreach($offices as $office) {
                    $folders[$office] = static::cleanFolderName(str_replace(' ', '',
                        str_replace('-', '', strtolower($office))));
                }
                return $folders;
            } else {
                $folders = [];
                $offices =  $user->offices()->current()->get()->lists('display_name');
                foreach($offices as $office) {
                    $folders[$office] = static::cleanFolderName(str_replace(' ', '',
                        str_replace('-', '', strtolower($office))));
                }
                return $folders;
            }
        }
        return $folders;
    }
    private static function cleanFolderName($folder)
    {
        $cleanName = $folder;
        //Strip off the co prefix from things
        $cleanName = preg_replace('/^co/', '', $cleanName);
        $cleanName = preg_replace('/^assistant/', '', $cleanName);
        $cleanName = preg_replace('/vicepresident$/', 'vp', $cleanName);
        $cleanName = preg_replace('/educator$/', 'ed', $cleanName);
        $cleanName = preg_replace('/coordinator$/', '', $cleanName);
        return $cleanName;
    }

}
