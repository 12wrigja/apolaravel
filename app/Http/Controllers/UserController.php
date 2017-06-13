<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests\Users\UserDeleteRequest;
use APOSite\Http\Requests\Users\UserPersonalPageRequest;
use APOSite\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller {

    function __construct() {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function manage() {
        return view('users.pledge_management');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id) {
        $user = User::find($id);
        if ($user != null) {
            $big = $user->big;
            return response()->view('users.profile',['user'=>$user, 'big'=>$big]);
        } else {
            throw new NotFoundHttpException("User Not Found!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit(UserPersonalPageRequest $request,
                         $id) {
        $user = User::find($id);
        if ($user != null) {
            return view('users.profileedit')->with('user', $user);
        } else {
            throw new NotFoundHttpException("User Not Found!");
        }
    }

    public function statusPage(UserPersonalPageRequest $request,
                               $id) {
        $user = User::find($id);
        if ($user != null) {
            return view('contracts.status')
                ->with('contract', $user->contractForSemester(null))
                ->with('user', $user);
        } else {
            throw new NotFoundHttpException('User not found');
        }
    }

}
