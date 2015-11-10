<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests\Users\UserEditRequest;
use APOSite\Http\Requests\Users\UserDeleteRequest;
use APOSite\Http\Requests\Users\UserPersonalPageRequest;
use APOSite\Http\Transformers\UserSearchResultTransformer;
use APOSite\Models\Users\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use APOSite\Models\Semester;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('SSOAuth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Request::wantsJson()) {
            $users = null;
            if (Request::has('search') && Request::get('search')) {
                //Handle a search here.
                $query = Request::get('query');
                if ($query == null) {
                    $query = '';
                }
                $users = $this->searchUsers($query);
            } else {
                $users = $this->searchUsers("");
            }
            $attributes = Input::get('attr');
            if ($attributes == null) {
                $attributes = array();
            }
            $transformer = new UserSearchResultTransformer($attributes);
            $resource = new Collection($users, $transformer);
            $fractal = new Manager();
            return $fractal->createData($resource)->toJson();
        } else {
            return view('users.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required',
            'cwruID' => 'required|unique:tblmembers',
            'status' => 'required|numeric'
        );
        $messages = array(
            'cwruID.unique' => 'The :attribute is already registered.'
        );
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to('users/create')->withErrors($validator)->withInput(Input::except('password'));
        } else {
            $user = new User();
            $user->firstName = Input::get('firstName');
            $user->lastName = Input::get('lastName');
            $user->cwruID = Input::get('cwruID');
            $user->status = Input::get('status');
            $user->save();
            return Redirect::to('users/mange')->with('message', 'Successfully created the user.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if (Request::wantsJSON()) {
            if ($user != null) {
                return $user;
            } else {
                //TODO update this json response to be formatted the same as the others.
                return response('User not found.', 404);
            }
        }
        if ($user != null) {
            $big = User::find($user->big);
            return View::make('users.profile')->with(compact('user','big'));
        } else {
            throw new NotFoundHttpException("User Not Found!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(UserPersonalPageRequest $request, $id)
    {
        $user = User::find($id);
        if ($user != null) {
            return view('users.profileedit')->with('user', $user);
        } else {
            throw new NotFoundHttpException("User Not Found!");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update(UserEditRequest $request, $id)
    {
        $user = User::find($id);
        if ($user != null) {
            $attributes = $request->except(['first_name','last_name','family_id','big']);
            foreach($attributes as $key=>$value){
                if($value == ""){
                    $attributes[$key] = null;
                }
            }
            $user->fill($attributes);
            //Construct semester ID number from given info
            $user->graduation_semester = Semester::SemesterFromText($request->get('semester'),$request->get('year'),true)->id;
            $user->save();
            return Redirect::route('user_show',['id'=>$user->id]);
        } else {
            throw new NotFoundHttpException("User Not Found!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(UserDeleteRequest $request, $id)
    {
        $user = User::find($id);
        if ($user != null) {
            User::destroy($id);
            return Redirect::to('users/manage')->with('message', 'Successfully deleted the user.');
        } else {
            throw new NotFoundHttpException('User not found');
        }
    }

    private function searchUsers($text)
    {
        if ($text != "") {
            $users = User::where('first_name', 'LIKE', $text . '%')->orWhere('last_name', 'LIKE',
                $text . '%')->orWhere(DB::raw('CONCAT(first_name, " ", last_name)'), 'LIKE',
                $text . '%')->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC');
        } else {
            $users = User::query();
        }
        $users = $users->orderBy('first_name', 'ASC')->orderBy('last_name', 'ASC');
        return $users->get();
    }

    public function statusPage(UserPersonalPageRequest $request, $id)
    {
        $user = User::find($id);
        if ($user != null) {
            return view('contracts.status')->with('contract', $user->contractForSemester(null))->with('user',$user);
        } else {
            throw new NotFoundHttpException('User not found');
        }
    }

}
