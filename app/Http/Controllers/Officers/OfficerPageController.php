<?php namespace APOSite\Http\Controllers\Officers;

use APOSite\Http\Controllers\Controller;
use APOSite\Http\Requests;
use APOSite\Models\Office;

class OfficerPageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $offices = Office::AllInOrder()->Active()->get();
        $offices = $offices->filter(function ($office) {
            return $office->currentOfficers()->count() > 0;
        });
        return view('officers.currentOfficers')->with('offices', $offices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        //
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

}
