<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProjectType;
use App\ServiceType;

use Session;

class ServiceTypeController extends Controller
{
    private $oProjectType;
    private $oServiceType;

    public function __construct() {

       $this->middleware('auth');
       $this->oProjectType = new ProjectType;
       $this->oServiceType = new ServiceType;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->oProjectType->getAll();
        $services = $this->oServiceType->getAll();
        return view('typesofservices.index', compact('services','projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->oServiceType->insertST(
             $request->projectTypeId,
             $request->serviceTypeName
            );

        return redirect()->route('services.index')
                         ->with('info','Tipo de Proyecto Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $projects = $this->oProjectType->getAll();
        $service = $this->oServiceType->findById($id);
        return view('typesofservices.edit', compact('service','projects'));
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
        $this->oServiceType->updateST($id,
            $request->projectTypeId,
            $request->serviceTypeName
           );

        return redirect()->route('services.index')
                         ->with('info','Tipo de Proyecto Actualizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $service = $this->oServiceType->findById($id);
        return view('typesofservices.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oServiceType->deleteST($id);
        return redirect()->route('services.index')
                         ->with('info','Tipo de Proyecto Eliminado');
    }
}
