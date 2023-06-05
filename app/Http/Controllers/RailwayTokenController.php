<?php

namespace App\Http\Controllers;

use App\Models\RailwayToken;
use App\Http\Requests\StoreRailwayTokenRequest;
use App\Http\Requests\UpdateRailwayTokenRequest;

class RailwayTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "hello world";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRailwayTokenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRailwayTokenRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RailwayToken  $railwayToken
     * @return \Illuminate\Http\Response
     */
    public function show(RailwayToken $railwayToken)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RailwayToken  $railwayToken
     * @return \Illuminate\Http\Response
     */
    public function edit(RailwayToken $railwayToken)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRailwayTokenRequest  $request
     * @param  \App\Models\RailwayToken  $railwayToken
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRailwayTokenRequest $request, RailwayToken $railwayToken)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RailwayToken  $railwayToken
     * @return \Illuminate\Http\Response
     */
    public function destroy(RailwayToken $railwayToken)
    {
        //
    }
}
