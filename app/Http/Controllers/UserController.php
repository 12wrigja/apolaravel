<?php namespace APOSite\Http\Controllers;

use APOSite\Models\MemberStatus;
use APOSite\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(Request::wantsJson()) {
            return User::select('first_name','last_name','nickname','id')->get();
        }else {
            //TODO write the listing page for users and allow users to search for each other?
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make('users.create')->with('statuses', MemberStatus::lists('status', 'id'));
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
        if ($user != null) {
            return View::make('users.profile')->with('user', $user)->with('permissions', $user->permissions());
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
    public function edit($id)
    {
        return View::make('users.edit')->with('user', User::find($id))->with('statuses', MemberStatus::lists('status', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user != null) {
            User::destroy($id);
            return Redirect::to('users/manage')->with('message', 'Successfully deleted the user.');
        } else {
            throw new NotFoundHttpException('User not found');
        }
    }

    public function search()
    {
        $text = Input::get('query');
        $users = $this->searchUsers($text);
        $attributes = Input::get('attr');
        if ($attributes != null) {
            $attributes = explode(',', $attributes);
            foreach ($attributes as $attr) {
                $users = $users->addSelect($attr);
            }
        }
        $users = $users->get();
        return $users;
    }

    private function searchUsers($text)
    {
        if ($text != "") {
            $users = User::with(['status' => function ($q) {
                $q->select('id', 'status');
            }])->where('firstName', 'LIKE', $text . '%')->orWhere('lastName', 'LIKE', $text . '%')->orWhere(DB::raw('CONCAT(firstName, " ", lastName)'), 'LIKE', $text . '%')->orderBy('firstName', 'ASC')->orderBy('lastName', 'ASC');
        } else {
            $users = null;
        }
        return $users;
    }

}
