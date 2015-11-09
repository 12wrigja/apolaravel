<?php

namespace APOSite\Http\Middleware;

use APOSite\Http\Controllers\AccessController;
use APOSite\Http\Controllers\LoginController;
use Closure;

class AddUserMenuItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = LoginController::currentUser();
        if($user != null){

            //Add menu items to the user
            $menu_items = [];

            //Exec functionality
            //Membership
            if(AccessController::isMembership($user)){
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Membership Functions";
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Manage service reports";
                $item->url = route('report_manage',['type'=>'service_reports']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage brotherhood reports";
                $item->url = route('report_manage',['type'=>'brotherhood_reports']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "View Chapter Statistics";
                $item->url = route('chapterstatistics');
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "View Contract Progress";
                $item->url = route('contract_progress');
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Create Chapter Meeting";
                $item->url = route('report_create',['type'=>'chapter_meetings']);
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Create Exec Meeting";
                $item->url = route('report_create',['type'=>'exec_meetings']);
                array_push($menu_items,$item);

            }

            if(AccessController::isService($user)){

            }

            if(AccessController::isFellowship($user)){
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Fellowship Functions";
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Manage brotherhood reports";
                $item->url = route('report_manage',['type'=>'brotherhood_reports']);
                array_push($menu_items, $item);

            }
            if(AccessController::isTreasurer($user)){
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Treasurer Functions";
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Manage Dues";
                $item->url = route('report_create',['type'=>'dues_reports']);
                array_push($menu_items,$item);
            }
            if(AccessController::isHistorian($user)){

            }

            if(AccessController::isSecretary($user)){
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Secretary Functions";
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Create Chapter Meeting";
                $item->url = route('report_create',['type'=>'chapter_meetings']);
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Create Exec Meeting";
                $item->url = route('report_create',['type'=>'exec_meetings']);
                array_push($menu_items,$item);
            }

            if(AccessController::isSergentAtArms($user)){

            }

            if(AccessController::isPresident($user)){

            }

            if(AccessController::isExecMember($user)){

            }
            if(AccessController::isPledgeEducator($user)){
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Pledge Educator Functions";
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "Create Pledge Meeting";
                $item->url = route('report_create',['type'=>'pledge_meetings']);
                array_push($menu_items,$item);

                $item = new \stdClass();
                $item->text = "View Pledge Contract Progress";
                $item->url = route('contract_progress');
                array_push($menu_items, $item);
            }


            $item = new \stdClass();
            $item->isHeader = true;
            $item->text = "Reports";
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Submit a service report";
            $item->url = route('report_create',['type'=>'service_reports']);
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Submit a brotherhood report";
            $item->url = route('report_create',['type'=>'brotherhood_reports']);
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Account";
            $item->isHeader = true;
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "View Profile";
            $item->url = route('user_show',['id'=>$user->id]);
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "View Contract";
            $item->url = route('user_status',['id'=>$user->id]);
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Other";
            $item->isHeader = true;
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "View Event Calendar";
            $item->url = route('calendar');
            array_push($menu_items,$item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Logout";
            $item->url = route('logout');
            array_push($menu_items,$item);

            $user->menu_items = $menu_items;
        }
        return $next($request);
    }
}
