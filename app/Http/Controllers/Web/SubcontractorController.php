<?php

namespace App\Http\Controllers\Web;

use App\Subcontractor;
use App\SubcontractorInvDetail;
use App\Payable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SubcontractorController extends Controller
{
    private $oSubcontractor;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware("permission:BA");
        $this->oSubcontractor           = new Subcontractor;
        $this->oSubcontractorInvDetail  = new SubcontractorInvDetail;
        $this->oPayable                 = new Payable;
    }

    public function index(Request $request)
    {
        $subcontractors = $this->oSubcontractor->getAllByCompany(session('companyId'));

         if($request->ajax()){
                return $subcontractors;
            }
            
        return view('module_administration.subcontractors.index', compact('subcontractors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('module_administration.subcontractors.create');
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    public function store(Request $request)
    {
        $rs = $this->oSubcontractor->insertS(
            session('countryId'),
            session('companyId'),
            $request->all()
        );
          
          return $rs;

    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {
    //     // $countrys = Country::all();
    //     $contactTypes = $this->oContactType->getAllByOffice(session('companyId'));
    //     $client   = $this->oSubcontractor->findById($id, session('countryId'));

    //     return view('module_administration.clients.edit', compact('client', 'countrys','contactTypes'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request,$subcontractorId)
    {
       
             $rs = $this->oSubcontractor->updateS(
               $subcontractorId,
               $request->all()
              );

              if($request->ajax()){
                return $rs;
            }

        // $notification = array('alert-type' => $rs['alert'],'message' => $rs['message']);
        // return redirect()->route('clients.index')->with($notification);
    }
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
        return view('module_administration.clients.show', compact('subcontractor'));
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
//----------------QUERYS ASINCRONIOUS -------------->>>>
    public function getFiltered($name = '')
    {
        $results = Subcontractor::where('subcontractorName', 'LIKE', "%$name%")
            ->orWhere('companyName', 'LIKE', "%$name%")
            ->where('countryId', session('countryId'))
            ->orderBy('subcontractorName', 'ASC')
            ->get();

        return json_encode($results);
    }
   // public function getNumberFormat()
   //  {
   //      $clientNumberFormat = $this->oCountryConfiguration->generateClientNumberFormat(session('countryId'));
   //      return json_encode($clientNumberFormat);
   //  }

}
