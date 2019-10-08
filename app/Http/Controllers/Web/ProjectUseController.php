<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\ProjectUse;
use Illuminate\Http\Request;

class ProjectUseController extends Controller
{
    private $oProjectUse;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oProjectUse = new ProjectUse;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->oProjectUse->getAll();
        return view('projectUseS.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->oProjectUse->insertST(
            $request->projectUseName
        );

        $notification = array(
            'message'    => 'Uso de Proyecto Creado',
            'alert-type' => 'success',
        );

        return redirect()->route('projectUses.index')
            ->with($notification);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = $this->oProjectUse->findById($id);
        return view('projectuses.edit', compact('project'));
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
        $this->oProjectUse->updateST($id,
            $request->projectUseName
        );

        $notification = array(
            'message'    => 'Uso de Proyecto Modificado',
            'alert-type' => 'success',
        );

        return redirect()->route('projectUses.index')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = $this->oProjectUse->findById($id);
        return view('projectuses.show', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oProjectUse->deleteST($id);

        $notification = array(
            'message'    => 'Uso de Proyecto Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('projectUses.index')
            ->with($notification);
    }
}
