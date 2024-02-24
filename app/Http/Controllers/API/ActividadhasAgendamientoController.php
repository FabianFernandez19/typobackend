<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ActividadhasAgendamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $actividadhasAgendamiento = ActividadhasAgendamiento::all();
        return response()->json($actividadhasAgendamiento, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $actividadhasAgendamiento = new ActividadhasAgendamiento();
        $actividadhasAgendamiento->actividad_id =$request->actividad_id;
        $actividadhasAgendamiento->agendamiento_id =$request->agendamiento_id;
        $actividadhasAgendamiento->save();
        return response()->json($actividadhasAgendamiento, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $actividadhasAgendamiento = ActividadhasAgendamiento::find($id);
        return response()->json($actividadhasAgendamiento,200);
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
        $actividadhasAgendamiento = new ActividadhasAgendamiento();
        $actividadhasAgendamiento->actividad_id =$request->actividad_id;
        $actividadhasAgendamiento->agendamiento_id =$request->agendamiento_id;
        $actividadhasAgendamiento->update();
        return response()->json($actividadhasAgendamiento, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividadhasAgendamiento = ActividadhasAgendamiento::find($id);
        if($actividadhasAgendamiento){
        $actividadhasAgendamiento->delete();
        return response()->json($actividadhasAgendamiento, 200);
    }
}
}