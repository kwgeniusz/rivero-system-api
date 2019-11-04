<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProjectDescription;

class ProjectDescriptionController extends Controller
{
   private $oProjectDescription;

    public function __construct() {

       $this->middleware('auth');
       $this->oProjectDescription = new ProjectDescription;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $projects = $this->oProjectDescription->getAll();
        return view('module_configuration.projectdescriptions.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->oProjectDescription->insertPT( $request->projectDescriptionName,1);

        $notification = array(
            'message'    => 'Descripcion de Proyecto Creado',
            'alert-type' => 'success',
        );
        return redirect()->route('projectDescriptions.index')
                         ->with($notification);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $project = $this->oProjectDescription->findById($id);
        return view('module_configuration.projectdescriptions.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
       
        $this->oProjectDescription->updatePT($id,$request->projectDescriptionName);

        $notification = array(
            'message'    => 'Descripcion de Proyecto Modificada',
            'alert-type' => 'success',
        );

        return redirect()->route('projectDescriptions.index')
                         ->with($notification);
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $project = $this->oProjectDescription->findById($id);
        return view('module_configuration.projectdescriptions.show', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->oProjectDescription->deletePT($id);

        $notification = array(
            'message'    => 'Descripcion de Proyecto Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('projectDescriptions.index')
                         ->with($notification);
    }
}
