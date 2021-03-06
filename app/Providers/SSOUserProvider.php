<?php namespace APOSite\Providers;

use APOSite\GlobalVariable;
use APOSite\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Auth;
use APOSite\Models\Users\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class SSOUserProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
//                $user = $this->AddMenuItems(Auth::user());
                return $view; //->with('currentUser', $user);
            } else {
                return $view;
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function AddMenuItems(User $user)
    {
        if ($user != null) {

            //Add menu items to the user
            $menu_items = [];

            //Exec functionality
            //Membership
            if (AccessController::isMembership($user)) {
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Membership Functions";
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Service Reports";
                $item->url = route('report_manage', ['type' => 'service_reports']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Brotherhood Reports";
                $item->url = route('report_manage', ['type' => 'brotherhood_reports']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Contracts Signed";
                $item->url = route('contract_manage');
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
                $item->url = route('report_create', ['type' => 'chapter_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Chapter Meetings";
                $item->url = route('report_manage', ['type' => 'chapter_meetings']);
                array_push($menu_items, $item);


                $item = new \stdClass();
                $item->text = "Create Exec Meeting";
                $item->url = route('report_create', ['type' => 'exec_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Exec Meetings";
                $item->url = route('report_manage', ['type' => 'exec_meetings']);
                array_push($menu_items, $item);

            }

            if (AccessController::isService($user)) {

            }

            if (AccessController::isFellowship($user)) {
//                $item = new \stdClass();
//                $item->isHeader = true;
//                $item->text = "Fellowship Functions";
//                array_push($menu_items,$item);
//
//                $item = new \stdClass();
//                $item->text = "Manage brotherhood reports";
//                $item->url = route('report_manage',['type'=>'brotherhood_reports']);
//                array_push($menu_items, $item);

            }
            if (AccessController::isTreasurer($user)) {
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Treasurer Functions";
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Dues";
                $item->url = route('report_create', ['type' => 'dues_reports']);
                array_push($menu_items, $item);
            }
            if (AccessController::isHistorian($user)) {

            }

            if (AccessController::isSecretary($user)) {
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Secretary Functions";
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Create Chapter Meeting";
                $item->url = route('report_create', ['type' => 'chapter_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Chapter Meetings";
                $item->url = route('report_manage', ['type' => 'chapter_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Create Exec Meeting";
                $item->url = route('report_create', ['type' => 'exec_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Exec Meetings";
                $item->url = route('report_manage', ['type' => 'exec_meetings']);
                array_push($menu_items, $item);
            }

            if (AccessController::isSergentAtArms($user)) {

            }

            if (AccessController::isPresident($user)) {

            }

            if (AccessController::isExecMember($user)) {

            }
            if (AccessController::isPledgeEducator($user)) {
                $item = new \stdClass();
                $item->isHeader = true;
                $item->text = "Pledge Educator Functions";
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Create Pledge Meeting";
                $item->url = route('report_create', ['type' => 'pledge_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Manage Pledge Meetings";
                $item->url = route('report_manage', ['type' => 'pledge_meetings']);
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "View Pledge Contract Progress";
                $item->url = route('contract_progress');
                array_push($menu_items, $item);

                $item = new \stdClass();
                $item->text = "Pledge Management";
                $item->url = route('user_manage');
                array_push($menu_items, $item);
            }


            $item = new \stdClass();
            $item->isHeader = true;
            $item->text = "Reports";
            array_push($menu_items, $item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Submit a Service Report";
            $item->url = route('report_create', ['type' => 'service_reports']);
            array_push($menu_items, $item);

            // Service report menu item
            $item = new \stdClass();
            $item->text = "Submit a Brotherhood Report";
            $item->url = route('report_create', ['type' => 'brotherhood_reports']);
            array_push($menu_items, $item);

            // Brother of the week form
            $item = new \stdClass();
            $item->text = "Submit Brother of the Week";
            $item->url = "https://docs.google.com/a/case.edu/forms/d/1spt1Y8Chmh7n8b2FDToSSDPDrsoE2pCMl718wqZ9vpA/viewform";
            $item->external = true;
            array_push($menu_items, $item);

            // Service report menu item
            $item = new \stdClass();
            $item->text = "Account";
            $item->isHeader = true;
            array_push($menu_items, $item);

            // Contract signing.
            if (GlobalVariable::ContractSigning()->value) {
                $item = new \stdClass();
                $item->text = "Sign a Contract";
                $item->url = route('sign_contract');
                array_push($menu_items, $item);
            }

            // Service report menu item
            $item = new \stdClass();
            $item->text = "View Profile";
            $item->url = route('user_show', ['cwruid' => $user->id]);
            array_push($menu_items, $item);

            // Service report menu item
            $item = new \stdClass();
            $item->text = "View Contract";
            $item->url = route('user_status', ['id' => $user->id]);
            array_push($menu_items, $item);

            // Service report menu item
            $item = new \stdClass();
            $item->text = "Other";
            $item->isHeader = true;
            array_push($menu_items, $item);

            $item = new \stdClass();
            $item->text = "View APO Documents";
            $item->url = route('document_list');
            array_push($menu_items, $item);

            //Service report menu item
            $item = new \stdClass();
            $item->text = "Logout";
            $item->url = route('logout');
            $item->method = "post";
            array_push($menu_items, $item);

            $user->menu_items = $menu_items;
        }
        return $user;
    }
}
