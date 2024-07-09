<?php

namespace App\Http\Controllers;

use App\Models\TeamApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamApplicationController extends Controller
{
    public function index()
    {
        //
    }
   public function create()
    {
        //
    }
    public function store(int $teamId)
    {
        $auth = Auth::user();

        dd($auth);

        return response()->json('success', 'Aplicação enviada com sucesso');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
