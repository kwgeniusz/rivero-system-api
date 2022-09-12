<?php

namespace App\Http\Controllers\Web\Inventory;

use Auth;
// use App\CompanyConfiguration;
use App\Service;
use App\Models\Inventory\ServiceEquivalence;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class ServiceEquivalenceController extends Controller
{
    private $oService;
    private $oServiceEquivalence;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oService              = new Service;
        $this->oServiceEquivalence   = new ServiceEquivalence;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $serviceEquivalences = $this->oService->getAllByCompanyWithLinkedService(session('companyId'),$request->companyToLink);    

         if($request->ajax()) {
               return $serviceEquivalences;
                }

        return view('module_inventory.service_equivalence.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // Servicios de JD RIVERO ORIGEN, VALIDACION: NO DEBEN TENER EQUIVALENCIA PARA SER MOSTRADOS
     
        // $filtered = $destinationServiceList->filter(function ($item) {
        //          $item->serviceEquivalence == [];

        //          if(){
        //             return $item
        //          }
        // })->values();


        if($request->ajax()) {
         return [
                 'localServiceList'       => $filtered->toArray(),
                 'destinationServiceList' => $destinationServiceList,
                ];
        }
        // return view('module_contracts.clients.create', compact('contactTypes','clientNumberFormat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $localService       = $request->localService;
        $destinationService = $request->destinationService;

        $rs = $this->oServiceEquivalence->insertS($localService, $destinationService);

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

    //     $client       = $this->oGeneralLedger->findById($id, session('companyId'));
    //     $contactTypes = $this->oContactType->getAllByCompany(session('companyId'));

    //     return view('module_contracts.clients.edit', compact('client','contactTypes'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$clientId)
    {
             $rs = $this->oGeneralLedger->updateG(
               session('companyId'),
               $clientId,
               $request->all()
              );

              if($request->ajax()){
                return $rs;
            }

        // $notification = array('alert-type' => $rs['alert'],'message' => $rs['message']);
        // return redirect()->route('clients.index')->with($notification);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rs = $this->oGeneralLedger->deleteG(session('companyId'),$id);
          
         $notification = array(
            'message'    => $rs['message'],
            'alert-type' => $rs['alert'],
        );
        
        return $notification;
        // return redirect()->route('clients.index')->with($notification);
    }
    
}
