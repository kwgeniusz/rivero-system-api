<?php

namespace App\Http\Controllers\web\Inventory;

use App\Models\Inventory\ServiceCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    private $oServiceCategory;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oServiceCategory = new ServiceCategory;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $serviceCategories = $this->oServiceCategory->getAllByCompany(session('companyId'));
        
           if($request->ajax()){
                 return $serviceCategories;
            }

        return view('module_inventory.serviceCategories.index', compact('serviceCategories'));
    }

    // public function create(Request $request)
    // {
    //     $hasCost = $request->hasCost;

    //     return view('module_configuration.serviceCategories.create', compact('hasCost'));
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
     

        $rs = $this->oServiceCategory->insertS(
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
    //     $service = $this->oServiceCategory->findById($id);
    //     return view('module_configuration.serviceCategories.edit', compact('service'));
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
  
         $rs = $this->oServiceCategory->updateS($id,$request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $service = $this->oServiceCategory->findById($id);

         if($request->ajax()){
                return $service;
            }

        return view('module_configuration.serviceCategories.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oServiceCategory->deleteS($id);
        return redirect()->route('serviceCategories.index')
            ->with('success', 'Servicio Eliminado');
    }
}
