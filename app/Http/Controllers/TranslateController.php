<?php

namespace App\Http\Controllers;

use App\Models\Translate;
use App\Http\Requests\StoreTranslateRequest;
use App\Http\Requests\UpdateTranslateRequest;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTranslateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTranslateRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function show(Translate $translate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function edit(Translate $translate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTranslateRequest  $request
     * @param  \App\Models\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTranslateRequest $request, Translate $translate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Translate  $translate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Translate $translate)
    {
        //
    }
}
