<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProjectType;
use Session;

class ProjectTypeController extends Controller
{
   private $oProjectType;

    public function __construct() {

       $this->middleware('auth');
       $this->oProjectType = new ProjectType;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $projects = $this->oProjectType->getAll();
        return view('typesofprojects.index', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->oProjectType->insertPT( $request->projectTypeName,1);
        return redirect()->route('projects.index')
                         ->with('info','Tipo de Proyecto Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $project = $this->oProjectType->findById($id);
        return view('typesofprojects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
       
        $this->oProjectType->updatePT($id,$request->projectTypeName);

        return redirect()->route('projects.index')
                         ->with('info','Tipo de Proyecto Actualizado');
    }
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {

        $project = $this->oProjectType->findById($id);
        return view('typesofprojects.show', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $this->oProjectType->deletePT($id);
        return redirect()->route('projects.index')
                         ->with('info','Tipo de Proyecto Eliminado');
    }
}
