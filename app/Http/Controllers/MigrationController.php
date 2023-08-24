<?php

namespace App\Http\Controllers;

use App\Models\Migration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MigrationController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Migration  $migration
     * @return \Illuminate\Http\Response
     */
    public function show(Migration $migration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Migration  $migration
     * @return \Illuminate\Http\Response
     */
    public function edit(Migration $migration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Migration  $migration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Migration $migration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Migration  $migration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Migration $migration)
    {
        //
    }
}
