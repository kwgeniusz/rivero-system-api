<?php

namespace App\Http\Controllers\Web;

use App\Subcontractor;
use App\SubcontractorInvDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SubcontractorController extends Controller
{
    private $oSubcontractor;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware("permission:BA");
        $this->oSubcontractor = new Subcontractor;
        $this->oSubcontractorInvDetail = new SubcontractorInvDetail;
    }

    // /**
    //  * Show the form for creating a new resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function create()
    // {
    
    //     $clientNumberFormat = $this->oCountryConfiguration->generateClientNumberFormat(session('countryId'));
    //     // $countrys     = Country::all();
    //     $contactTypes = $this->oContactType->getAllByOffice(session('officeId'));

    //     return view('module_contracts.clients.create', compact('countrys','contactTypes','clientNumberFormat'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(ClientRequest $request)
    // {
    //     $clients = $this->oSubcontractor->insertClient(
    //         session('countryId'),
    //         $request->clientName,
    //         $request->clientAddress,
    //         $request->contactTypeId, 
    //         $request->clientPhone,
    //         $request->clientEmail
    //     );

    //     if($request->ajax()){
    //             return $clients;
    //         }
            
    //     $notification = array(
    //         'message'    => 'Cliente Creado Exitosamente '.$clients->clientCode,
    //         'alert-type' => 'success',
    //     );

    //     return redirect()->route('clients.index')
    //                      ->with($notification);
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     // $countrys = Country::all();
    //     $contactTypes = $this->oContactType->getAllByOffice(session('officeId'));
    //     $client   = $this->oSubcontractor->findById($id, session('countryId'));

    //     return view('module_contracts.clients.edit', compact('client', 'countrys','contactTypes'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(ClientRequest $request, $id)
    // {
    //     $this->oSubcontractor->updateClient($id,
    //         session('countryId'),
    //         $request->clientName,
    //         $request->clientAddress,
    //         $request->contactTypeId,  
    //         $request->clientPhone,
    //         $request->clientEmail
    //     );
    //     $notification = array(
    //         'message'    => 'Cliente Modificado Exitosamente',
    //         'alert-type' => 'success',
    //     );
    //     return redirect()->route('clients.index')
    //         ->with($notification);
    // }
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Request $request,$subcontId)
    {
        $subcontractor = $this->oSubcontractor->findById($subcontId,session('countryId'));

           if($request->ajax()){
              return $subcontractor;
            }
        return view('module_contracts.clients.show', compact('subcontractor'));
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     $result = $this->oSubcontractor->deleteClient($id,session('countryId'));

    //      $notification = array(
    //         'message'    => $result['msj'],
    //         'alert-type' => $result['alert'],
    //     );
    //     return redirect()->route('clients.index')
    //         ->with($notification);
    // }

    public function listSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorInvDetail->getAllByInvDetail($request->invDetailId);
       return $rs;
    }
    public function addSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorInvDetail->insertS($request->all());
       return $rs;
    }
    public function removeSubcontInvDetail(Request $request)
    { 
       $rs   = $this->oSubcontractorInvDetail->deleteS($request->subcontInvDetailId);
       return $rs;
    }
//----------------QUERYS ASINCRONIOUS -------------->>>>
    public function getFiltered($subcontName = '')
    {
        $results = Subcontractor::where('subcontName', 'LIKE', "%$subcontName%")
            ->where('countryId', session('countryId'))
            ->orderBy('subcontName', 'ASC')
            ->get();

        return json_encode($results);
    }
   // public function getNumberFormat()
   //  {
   //      $clientNumberFormat = $this->oCountryConfiguration->generateClientNumberFormat(session('countryId'));
   //      return json_encode($clientNumberFormat);
   //  }

}
