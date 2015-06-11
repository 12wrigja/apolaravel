<?php namespace APOSite\Http\Controllers;

use APOSite\Models\CRequirement;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

class ContractRequirementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('contracts.requirements.index')->with('contractReqs', CRequirement::all());
    }


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
        $contract_req = CRequirement::create($input);
        return $contract_req;

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        return CRequirement::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
