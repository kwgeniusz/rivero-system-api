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
        $services = $this->oService->getAllByOffice(session('officeId'));

           if($request->ajax()){
                return $services;
            }
      // return view('typesofservices.index', compact('services'));
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
            $unit1 = 'sqft'; $unit2 = 'ea';
        }else {
            $unit1 = 'N'; $unit2 = 'N';
        }

        $this->oService->insertS(
            session('countryId'),
            session('officeId'),
            $request->serviceName,
            $request->hasCost,
            $unit1,
            $unit2,
            $request->cost1,
            $request->cost2
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
        $service = $this->oService->findById($id);
        return view('typesofservices.edit', compact('service'));
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
        $this->oService->updateS($id,
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
        $service = $this->oService->findById($id);

         if($request->ajax()){
                return $service;
            }

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
        $this->oService->deleteS($id);
        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }
}
