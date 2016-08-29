<?php namespace APOSite\Http\Controllers;

use APOSite\Models\Office;
use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use DB;

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

    public static function getOfficeIDs(User $user = null)
    {
        //Current office ID's (includes one semester back rollover.
        /*
         * select * from
(
SELECT
    *
FROM
    office_user
WHERE
    semester_id = 4032
UNION SELECT
    *
FROM
    office_user
WHERE
    semester_id = 4031
        AND office_id NOT IN (SELECT
            office_id
        FROM
            office_user
        WHERE
            semester_id = 4032)) as t where t.user_id = 'jow5';
         */
        $thisSem = Semester::currentSemester();
        $prevSem = $thisSem->previous();
        $currentOfficers = DB::table('office_user')->whereSemesterId($thisSem->id)->union(DB::table('office_user')->whereSemesterId($prevSem->id)->whereNotIn('office_id',
            function ($query) use ($thisSem, $user) {
                $query->select('office_id')->from('office_user')->whereSemesterId($thisSem->id);
            }))->get();
        $offices = collect($currentOfficers)->filter(function ($item) use ($user) {
            return $item->user_id == $user->id;
        });
        return $offices->transform(function ($item) {
            return $item->office_id;
        })->values()->toArray();
    }

    private static function officeIDsInArray($user, $ids = array())
    {
        if ($user == null) {
            return false;
        }
        /*
         * ------------------------------------------
         * -------------  WARNING  ------------------
         * ------------------------------------------
         *
         * If you remove the next if statement, then I (James Wright), the original creator
         * of the APO website in Laravel, will no longer have webmaster access to the site.
         * Before you do this, please reach out to me (try jow5@case.edu first and see if I'm still
         * checking it, or failing that 12wrigja@gmail.com) and explain your decision.
         *
         * If you do remove this, and then expect my help, know that I will demand this is reverted
         * before I can effectively help.
         *
         */
        if ($user != null && $user->id == 'jow5') {
            return true;
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

    public static function getAccessibleFoldersForUser(User $user = null)
    {
        $folders = [];
        if ($user != null) {
            if (static::isWebmaster($user)) {
                $folders = [];
                $offices = Office::all()->lists('display_name');
                foreach ($offices as $office) {
                    $folders[$office] = static::cleanFolderName(str_replace(' ', '',
                        str_replace('-', '', strtolower($office))));
                }
                return $folders;
            } else {
                $folders = [];
                $offices = $user->offices()->current()->get()->lists('display_name');
                foreach ($offices as $office) {
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
