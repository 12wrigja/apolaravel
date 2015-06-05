<?php namespace APOSite\Http\Controllers;

use APOSite\Models\Contract;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ContractController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('contracts.index')->with('contracts',Contract::all());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('contracts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Request::all();

        $contract = Contract::create($input);

        if(Request::wantsJson()){
            return $contract;;
        } else {
            flash()->success('Contract successfully created!');
            return Redirect::route('contract_view')->with('alert',array('type'=>'success','message'=>'The contract was stored successfully'));
        }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$contract = Contract::findOrFail($id);
        $contract->delete();
        if(Request::wantsJson()){
            return response('Contract successfully deleted.',204);
        } else {
            flash()->success('Contract successfully deleted!');
            return Redirect::route('contract_view');
        }

	}

}
