<?php namespace APOSite\Http\Controllers;

use APOSite\Http\Requests\StoreContractRequirementRequest;
use APOSite\Models\EventFilter;
use Illuminate\Support\Facades\Request;
use APOSite\Models\ContractRequirement;
use Illuminate\Support\Facades\Input;

class ContractRequirementController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Request::wantsJSON()) {
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
    public function store(StoreContractRequirementRequest $request)
    {
        $input = Request::all();
        $contract_req = ContractRequirement::create($input);
        if (Input::has('filters')) {
            $filterData = Input::has('filters');
            foreach ($filterData as $data) {
                $filter = EventFilter::create($data);
                $filter->Requirement()->associate($contract_req);
                $filter->save();
            }
        }
        $contract_req->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('contracts.requirements.edit')->with('requirement', ContractRequirement::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
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

    public function getEventTypes()
    {
        return [
            'Chapter Meeting',
            'Exec Meeting',
            'Service Event',
            'Brotherhood Event'
        ];
    }

}
