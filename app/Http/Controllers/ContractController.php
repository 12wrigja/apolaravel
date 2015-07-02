<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests\EditContractRequest;
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
        if(Request::wantsJSON()){
            return Contract::with('Requirements')->get();
        } else {
            return view('contracts.index')->with('contracts', Contract::all());
        }
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
        flash()->success($contract->display_name.' successfully created!');
        if(Request::wantsJson()){
            return $contract;
        } else {
            return Redirect::route('contract_view');
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
		$contract = Contract::findOrFail($id);
        $requirements = $contract->requirements()->get();
        $ids = [];
        foreach($requirements as $requirement){
            $ids[] = $requirement->id;
        }
        return view('contracts.edit')->with('contract',$contract)->with('contract_requirements',json_encode($ids));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param EditContractRequest $request
     * @param  int $id
     * @return Response
     */
	public function update(EditContractRequest $request, $id)
	{
        $input = Request::all();
        $contract = Contract::findOrFail($id);
        $contract->fill($input);
        $requirements = Request::input('requirements');
        if($requirements != null){
            $contract->requirements()->detach();
            foreach($requirements as $id){
                $requirement = ContractRequirement::findOrFail($id);
                $contract->requirements()->attach($requirement);
            }
        }
        $contract->save();
        flash()->success($contract->display_name.' successfully edited!');
        if(Request::wantsJson()){
            return $contract;
        } else {
            return Redirect::route('contract_view');
        }
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
