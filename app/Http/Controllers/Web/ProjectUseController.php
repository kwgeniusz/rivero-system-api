<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProjectUse;

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
    public function index(Request $request)
    {
        $projects = $this->oProjectUse->getAll();
           
              if($request->ajax()){
                return $projects;
            }

        return view('module_configuration.projectuses.index', compact('projects'));
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

        return redirect()->route('projectuses.index')
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
        return view('module_configuration.projectuses.edit', compact('project'));
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
    public function show(Request $request,$id)
    {
        $project = $this->oProjectUse->findById($id);

         if($request->ajax()){
                return $project;
            }
        return view('module_configuration.projectuses.show', compact('project'));
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

   public function getProjectDescription($projectUseId)
   {
       $projectDescriptions = ProjectUse::find($projectUseId)->projectDescription()->get();
      
       return $projectDescriptions;
   }

}
