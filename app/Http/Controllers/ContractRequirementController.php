<?php namespace APOSite\Http\Controllers;

use Illuminate\Support\Facades\Request;
use APOSite\Models\ContractRequirement;

class ContractRequirementController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if(Request::wantsJSON()){
            return ContractRequirement::all();
        } else {
            return view('contracts.requirements.index')->with('contractReqs', ContractRequirement::all());
        }
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('contracts.requirements.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        $input = Request::all();
        $contract_req = ContractRequirement::create($input);
        if(Input::has('filters')){
            $filters = Input::has('filters');
            foreach($filters as $filter){

            }
        }
        return $contract_req;
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
		//
	}

    public function getEventTypes(){
        return [
            'Chapter Meeting',
            'Exec Meeting',
            'Service Event',
            'Brotherhood Event'
        ];
    }

}
