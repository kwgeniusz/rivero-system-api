<?php

namespace App\Http\Controllers\Web\Accounting;

use Auth; 
use Carbon\Carbon;
use App\Models\Accounting\TransactionHeaderTmp;
use App\Models\Accounting\GeneralLedger;
use App\CompanyConfiguration;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionHeaderTmpController extends Controller
{
    private $oHeader;
    private $oGeneralLedger;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oHeader                      = new TransactionHeaderTmp;
        $this->oGeneralLedger               = new GeneralLedger;
        $this->oCompanyConfiguration        = new CompanyConfiguration;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companyConfig = $this->oCompanyConfiguration->findByCompany(session('companyId'));
        $year = $companyConfig[0]->accYear;
        
        //AGREGAR LA FECHA QUE VIENE DE LA CONFIGURACION DE CONTABILIDAD.
    //   $dateNow = Carbon::now(session('companyTimeZone'));
    //   $year    = '2020';

    //    $transactions   = $this->oTransaction->getAllByYear($sign,$year);
       $headers        = $this->oHeader->getAllByYear($year);
         
        if($request->ajax()) {
              return ['headers'    => $headers, 
                      'year'           => $year];
         }

        return view('module_accounting.transaction_header_tmp.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $chartOfAccount      = $this->oGeneralLedger->getAllByType(session('companyId'), GeneralLedger::TRANSACTION);
     
        if($request->ajax()) {
         return $chartOfAccount;
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
        
        $rs = $this->oHeader->insertHeaderWithTransactions(
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

    //     $client       = $this->oHeader->findById($id, session('companyId'));
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
    // public function update(Request $request,$transactionId)
    // {
        
    //          $rs = $this->oHeader->updateT(
    //            session('companyId'),
    //            $transactionId,
    //            $request->all()
    //           );

    //           if($request->ajax()){
    //             return $rs;
    //         }

    //     // $notification = array('alert-type' => $rs['alert'],'message' => $rs['message']);
    //     // return redirect()->route('clients.index')->with($notification);
    // }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $header = $this->oHeader->findById($id,session('companyId'));

           if($request->ajax()){
              return $header;
            }
        // return view('module_contracts.clients.show', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $rs = $this->oHeader->deleteT(session('companyId'),$id);
          
    //      $notification = array(
    //         'message'    => $rs['message'],
    //         'alert-type' => $rs['alert'],
    //     );
        
    //     return $notification;
    //     // return redirect()->route('clients.index')->with($notification);
    // }
    public function updateBalance() {

        $rs = $this->oHeader->updateBalance();
    
        $notification = array('message'    => $rs['message'],'alert-type' => $rs['alert-type']);
        
        return $notification;
     }//end function

    public function validateHeader(Request $request) {

        $rs = $this->oHeader->updateValidation($request->id,1);
    
        $notification = array('message'=> $rs['message'],'alert-type' => $rs['alert-type']);
        
        return $notification;
    }//end function

       public function searchBetweenDates(Request $request)
       {
           $rs = TransactionHeader::with('transaction')
                            ->where('entryDate', '>=', $request->date1)
                            ->where('entryDate', '<=', $request->date2)
                            ->where('companyId', '=', session('companyId'))
                            ->orderBy('entryDate', 'DESC')
                            ->get();
                            
               if($rs->isEmpty()) {
                   $returnData = array('alert' => 'error', 'message' => 'No existen Registros para Este Rango de Fecha, escoja otro.');
                   return \Response::json($returnData, 500);
               }
   
           return $rs;
       }
// ================================ GENERAR ASIENTOS CONTABLES TEMPORALES  ====================================================//

// Logica para genear asientos contables temporales desde administracion
 public function generateTemporaryAccountingEntries(Request $request)
 {
    // $oTransactionHeaderTmp-> ;
    
 }//END OF PROCESS 














}//class end

