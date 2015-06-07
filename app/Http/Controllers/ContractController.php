<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests\StoreContractRequest;
use APOSite\Models\Contract;
use APOSite\Models\ContractRequirement;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

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
		return view('contracts.create')->with('requirements',ContractRequirement::all());
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreContractRequest $request
     * @return Response
     */
	public function store(StoreContractRequest $request)
	{
		$input = Request::all();
        $contract = Contract::create($input);
        $requirements = Request::input('requirements');
        if($requirements != null){
            foreach($requirements as $id){
                $requirement = ContractRequirement::findOrFail($id);
                $contract->requirements()->attach($requirement);
            }
        }
        flash()->success('Contract successfully created!');
        if(Request::wantsJson()){
            return $contract;;
        } else {
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
