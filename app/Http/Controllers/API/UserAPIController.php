<?php

namespace APOSite\Http\Controllers\API;

use APOSite\Http\Controllers\Controller;
use APOSite\Http\Requests\Users\UserCreateRequest;
use APOSite\Http\Requests\Users\UserDeleteRequest;
use APOSite\Http\Requests\Users\UserEditRequest;
use APOSite\Http\Transformers\UserSearchResultTransformer;
use APOSite\Models\Semester;
use APOSite\Models\Users\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserAPIController extends Controller {

    public static $SCOPE_VIEW_PROFILE = [
        'view-profile' => 'View your user profile and profiles of other APO members.',
    ];
    public static $SCOPE_EDIT_PROFILE = [
        'edit-profile' => 'View and edit your user profile.',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return Response | string
     */
    public function index() {
        // Retrieve the input attributes to search on.
        $searchKeys = Input::except('attrs');
        // Retrieve the extra attributes that are explicitly requested in the response
        $extraAttributes = Input::get('attrs');

        // Validate the search attributes. This will throw an exception if any key is invalid.
        $instance = new User();
        $searchFilterAttributes = $instance->validateSearchAttributes(array_keys($searchKeys));
        $users = User::MatchAllAttributes($searchKeys);

        // Compute the set of attributes to add in to the response.
        // If a filter was made, include that attribute in the response.
        if ($extraAttributes == null) {
            $extraAttributes = $searchFilterAttributes;
        } else {
            $extraAttributes = explode(',', $extraAttributes);
            $instance->validateSearchAttributes($extraAttributes);
            $extraAttributes = array_merge($extraAttributes, $searchFilterAttributes);
        }

        $transformer = new UserSearchResultTransformer($extraAttributes);
        $resource = new Collection($users, $transformer);
        $fractal = new Manager();
        return $fractal->createData($resource)->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(UserCreateRequest $request) {
        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->id = $request->get('cwru_id');
        $user->pledge_semester = Semester::currentSemester()->id;

        if ($user->save()) {
            //This is super shitty and shouldn't need to be done.
            $user = User::find($request->get('cwru_id'));
            if ($user->changeContract('Pledge')) {
                return response()->json(['status' => 'OK']);
            } else {
                abort(500, 'Unable to set contract of new user.');
            }
        } else {
            abort(500, 'Unable to successfully create a new user.');
        }
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
            $transformer = new UserSearchResultTransformer($attributes);
            $resource = new Item($user, $transformer);
            $fractal = new Manager();
            return $fractal->createData($resource)->toJson();
        } else {
            //TODO update this json response to be formatted the same as the others.
            return response('User not found.', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update(UserEditRequest $request, $id) {
        $userToUpdate = User::find($id);
        $currentUser = Auth::user();
        if ($userToUpdate != null) {
            $attributes = $request->except(['id', 'created_at', 'updated_at']);
            $pledgeEditOnly = ['family_id', 'big', 'pledge_semester', 'initiation_semester'];
            $semesters = ['pledge_semester', 'graduation_semester', 'initiation_semester'];
            foreach ($attributes as $key => $value) {
                if (!AccessController::isPledgeEducator($currentUser) &&
                    in_array($key, $pledgeEditOnly)
                ) {
                    abort(403, 'You are unable to modify the ' . $key . ' attribute.');
                }
                if (in_array($key, $semesters)) {
                    if ($value == 'current') {
                        $attributes[$key] = Semester::currentSemester()->id;
                    } else {
                        $attributes[$key] = Semester::SemesterFromText($value['semester'],
                                                                       $value['year'],
                                                                       true)->id;
                    }
                }
                if ($value == "") {
                    $attributes[$key] = null;
                }
            }
            $userToUpdate->fill($attributes);
            $userToUpdate->save();
            $fractal = new Manager();
            $item = new Item($userToUpdate, new UserSearchResultTransformer([]));
            return $fractal->createData($item)->toJson();
        } else {
            throw new NotFoundHttpException("User Not Found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy(UserDeleteRequest $request,
                            $id) {
        $user = User::find($id);
        if ($user != null) {
            User::destroy($id);
            if ($request->wantsJson()) {
                return response()->json(['status' => 'OK']);
            }
            return Redirect::to('users/manage')->with('message', 'Successfully deleted the user.');
        } else {
            throw new NotFoundHttpException('User not found');
        }
    }
//
//    private function searchUsers($text) {
//        if ($text != "") {
//            $users = User::where('first_name', 'LIKE', $text . '%')
//                         ->orWhere('last_name',
//                                   'LIKE',
//                                   $text . '%')
//                         ->orWhere(DB::raw('CONCAT(first_name, " ", last_name)'),
//                                   'LIKE',
//                                   $text . '%')
//                         ->orderBy('first_name', 'ASC')
//                         ->orderBy('last_name', 'ASC');
//        } else {
//            $users = User::query();
//        }
//        $users =
//            $users->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC')->select('first_name',
//                                                                                      'last_name',
//                                                                                      'nickname',
//                                                                                      'id');
//        return $users;
//    }

}
