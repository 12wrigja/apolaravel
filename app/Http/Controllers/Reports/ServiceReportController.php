<?php

namespace APO\Http\Controllers\Reports;

use APO\Models\ServiceReport;
use Illuminate\Http\Request;
use APO\Http\Requests;
use APO\Http\Controllers\Controller;
use APO\Http\Requests\Reports\ServiceReports\UpdateServiceReportRequest;
use APO\Http\Requests\Reports\ServiceReports\ReadServiceReportRequest;
use APO\Http\Requests\Reports\ServiceReports\DeleteServiceReportRequest;
use APO\Http\Requests\Reports\ServiceReports\CreateServiceReportRequest;
use Symfony\Component\EventDispatcher\Tests\Service;

class ServiceReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReadServiceReportRequest $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reports.servicereports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateServiceReportRequest $request)
    {
        $report = ServiceReport::create($request->except(['approved','creator_id']));
        //TODO add in the routing to the new resource.
        return response('{"response":"OK"}',200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceReportRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeleteServiceReportRequest $request, $id)
    {
        $report = ServiceReport::findOrFail($id);
        $report->delete();
    }
}
