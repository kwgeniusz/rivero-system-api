<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private $oService;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oService = new Service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $services = $this->oService->getAllByOffice(session('companyId'));
        
           if($request->ajax()){
                return $services;
            }

        $servicesWithPrice  = $services->filter(function($service){
            return $service->hasCost == 'Y';
           });   
       $servicesWithoutPrice  = $services->filter(function($service){
            return $service->hasCost == 'N';
           });  

        return view('module_configuration.services.index', compact('servicesWithPrice','servicesWithoutPrice'));
     
    }

    public function create(Request $request)
    {
        $hasCost = $request->hasCost;

        return view('module_configuration.services.create', compact('hasCost'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       if($request->hasCost == 'Y') {
          $this->validate($request, 
            ['serviceName' => 'required',
             'cost1' => 'required',
             'cost2' => 'required']);
            $unit1 = 'sqft'; $unit2 = 'ea';
        }else {
           $this->validate($request, 
            ['serviceName' => 'required']);  
            $unit1 = 'N'; $unit2 = 'N';
        }

        $this->oService->insertS(
            session('countryId'),
            session('companyId'),
            $request->serviceName,
            $request->hasCost,
            $unit1,
            $unit2,
            $request->cost1,
            $request->cost2
        );
        return redirect()->route('services.index')
            ->with('info', 'Servicio Nuevo Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->oService->findById($id);
        return view('module_configuration.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

       if($request->hasCost == 'Y') {
          $this->validate($request, 
            ['serviceName' => 'required',
             'cost1' => 'required',
             'cost2' => 'required']);
        }else {
           $this->validate($request, 
            ['serviceName' => 'required']);  
        }

        $this->oService->updateS(
            $id,
            $request->serviceName,
            $request->cost1,
            $request->cost2
        );

        return redirect()->route('services.index')
            ->with('info', 'Servicio Actualizado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $service = $this->oService->findById($id);

         if($request->ajax()){
                return $service;
            }

        return view('module_configuration.services.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oService->deleteS($id);
        return redirect()->route('services.index')
            ->with('success', 'Servicio Eliminado');
    }
}
