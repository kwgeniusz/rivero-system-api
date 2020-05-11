<?php

namespace App\Http\Controllers\web;

use App\Process;
use App\Country;
use App\ProcessDetail;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcessController extends Controller
{
    
    private $oCountry;
    

    public function __construct()
    {
        $this->oCountry        = new Country; 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $process = DB::select("SELECT * FROM `hrprocess`
            INNER JOIN country ON hrprocess.countryId = country.countryId
            INNER JOIN company ON hrprocess.companyId = company.companyId");
            // LEFT JOIN hrprocess_detail ON hrprocess.hrprocessId = hrprocess_detail.hrprocessId
            // INNER JOIN hrtransaction_type ON hrprocess_detail.hrtransactionTypeId = hrtransaction_type.hrtransactionTypeId");

        // $companys =  Company::orderBy('companyName', 'ASC')->get();
        // $companys = DB::table('company')->select('companyId', 'companyName', 'companyShortName')->get();
        // $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        // $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')->get();
        // $countrys   = $this->oCountry->getAll();
        return compact('process');
    }
    public function processDetail($id)
    {
        $processDetail = DB::select("SELECT * FROM `hrprocess_detail`
            INNER JOIN hrtransaction_type ON hrprocess_detail.hrtransactionTypeId = hrtransaction_type.hrtransactionTypeId
            WHERE hrprocess_detail.hrprocessId =" . $id);
           
        return compact('processDetail');
    }
    public function processTransactionType()
    {
        $hrTType = DB::table('hrtransaction_type')->select('hrtransactionTypeId', 'transactionTypeName')->get();
           
        return compact('hrTType');
    }
    
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $process = new Process();
        $process->countryId = $request->countryId;
        $process->companyId = $request->companyId;
        $process->processCode = $request->processCode;
        $process->processName = $request->processName;
        $process->save();
        return $process;
    }
    public function storeDetail(Request $request)
    {
        // return $request;
        $processDetail = new ProcessDetail();
        $processDetail->hrprocessId = $request->hrprocessId;
        $processDetail->hrtransactionTypeId = $request->hrtransactionTypeId;
        $processDetail->quantity = $request->quantity;
        $processDetail->amount = $request->amount;
        $processDetail->save();
        return $processDetail;
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
        
        $process = Process::find($id);
        $process->countryId = $request->countryId;
        $process->companyId = $request->companyId;
        // $process->processCode = $request->processCode;
        $process->processName = $request->processName;
        
        $process->save();
        return $process;
    }
    public function updateDetail(Request $request, $id)
    {
        
        $processDetail = ProcessDetail::find($id);
        $processDetail->hrtransactionTypeId = $request->hrtransactionTypeId;
        $processDetail->quantity = $request->quantity;
        $processDetail->amount = $request->amount;
        
        $processDetail->save();
        return $processDetail;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return 'entro';
        $periods = Periods::find($id);
        $periods->delete();
    
    }
    public function destroyDetail($id)
    {
        // return 'entro';
        $periods = ProcessDetail::find($id);
        $periods->delete();
    
    }
}
