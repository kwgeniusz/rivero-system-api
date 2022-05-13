<?php

namespace App\Http\Controllers\Web\Accounting;

use Auth;
use App\CompanyConfiguration;
use App\Models\Accounting\AuxiliaryBook;
use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 

class AuxiliaryBookController extends Controller
{
    private $oAuxiliaryBook;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oAuxiliaryBook        = new AuxiliaryBook;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         $auxiliaryBook = $this->oAuxiliaryBook->getAllByCompany(session('companyId'));
         
         if($request->ajax()) {
               return $auxiliaryBook;
                }

        return view('module_accounting.auxiliary_book.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $chartOfAccount              = $this->oAuxiliaryBook->getAllByCompany(session('companyId'));
        $accountTypeList             = $this->oAccountType->getAllByCountry(session('countryId'));
        $accountClassificationList   = $this->oAccountClassification->getAllByCountry(session('countryId'));
        
        if($request->ajax()) {
         return [
                 'chartOfAccount'            => $chartOfAccount,
                 'accountTypeList'           => $accountTypeList,
                 'accountClassificationList' => $accountClassificationList
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
 
        $rs = $this->oAuxiliaryBook->insertG(
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

    //     $client       = $this->oAuxiliaryBook->findById($id, session('companyId'));
    //     $contactTypes = $this->oContactType->getAllByOffice(session('companyId'));

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
             $rs = $this->oAuxiliaryBook->updateG(
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $AuxiliaryBooks = $this->oAuxiliaryBook->findById($id,session('companyId'));

           if($request->ajax()){
              return $AuxiliaryBooks;
            }
        // return view('module_contracts.clients.show', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rs = $this->oAuxiliaryBook->deleteG(session('companyId'),$id);
          
         $notification = array(
            'message'    => $rs['message'],
            'alert-type' => $rs['alert'],
        );
        
        return $notification;
        // return redirect()->route('clients.index')->with($notification);
    }
    
   public function closeYear()
    {
        $rs = $this->oAuxiliaryBookBalance->closeYear();
    
         $notification = array(
            'message'    => $rs['message'],
            'alert-type' => $rs['alert-type'],
        );
        
        return $notification;
  
    }


    // public function balanceUpdate()
    // {
    //     $rs = $this->oAuxiliaryBook->deleteG(session('companyId'),$id);
          
    //      $notification = array(
    //         'message'    => $rs['message'],
    //         'alert-type' => $rs['alert'],
    //     );
        
    //     return $notification;
    //     // return redirect()->route('clients.index')->with($notification);
    // }
}
