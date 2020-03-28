<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\ServiceTemplate;
use Illuminate\Http\Request;

class ServiceTemplateController extends Controller
{
    private $oServiceTemplate;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oServiceTemplate = new Servicetemplate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serviceTemplates = $this->oServiceTemplate->getAll();

           if($request->ajax()){
                return $serviceTemplates;
            }
        return view('module_configuration.servicetemplates.index', compact('serviceTemplates'));
    }
    public function create()
    {

        return view('module_configuration.servicetemplates.create', compact(''));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->oServiceTemplate->insertST(
            $request->serviceTypeName
        );

        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->oServiceTemplate->findById($id);
        return view('module_configuration.servicetemplates.edit', compact('service'));
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
        $this->oServiceTemplate->updateST($id,
            $request->serviceTypeName
        );

        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Actualizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $service = $this->oServiceTemplate->findById($id);

         if($request->ajax()){
                return $service;
            }

        return view('module_configuration.servicetemplates.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oServiceTemplate->deleteST($id);
        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }
}
