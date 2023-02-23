<?php

namespace App\Http\Controllers\web\Inventory;

use App\Models\Inventory\Service;
use App\Http\Controllers\Controller;
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
        $services = $this->oService->getAllByCompany(session('companyId'));
        
           if($request->ajax()){
                 return $services;
            }

        return view('module_inventory.services.index', compact('services'));
    }

    // public function create(Request $request)
    // {
    //     $hasCost = $request->hasCost;

    //     return view('module_configuration.services.create', compact('hasCost'));
    // }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

          $this->validate($request, 
            ['serviceName' => 'required']);
     

        $rs = $this->oService->insertS(
            session('countryId'),
            session('companyId'),
            $request->all()
        );

        if($request->ajax()){
                return $rs;
            }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $service = $this->oService->findById($id);
    //     return view('module_configuration.services.edit', compact('service'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
          $this->validate($request, 
            ['serviceName' => 'required']);
  
         $rs = $this->oService->updateS($id,$request->all());
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
