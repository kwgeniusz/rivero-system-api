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
        $countryId = session('countryId');
        $companyId = session('companyId');
        $process = DB::select("SELECT * FROM `hrprocess`
            INNER JOIN country ON hrprocess.countryId = country.countryId
            INNER JOIN company ON hrprocess.companyId = company.companyId
            WHERE hrprocess.countryId = $countryId
            AND hrprocess.companyId = $companyId");
            
        return compact('process');
    }
    public function processDetail($id)
    {
        $processDetail = DB::select("SELECT * FROM hrprocess
        LEFT JOIN hrprocess_detail ON hrprocess.hrprocessId = hrprocess_detail.hrprocessId
        INNER JOIN hrtransaction_type ON hrprocess_detail.transactionTypeCode = hrtransaction_type.transactionTypeCode
            WHERE hrtransaction_type.companyId = hrprocess.companyId AND  hrprocess.hrprocessId =" . $id);
        return compact('processDetail');
    }
    public function processTransactionType($idCompany)
    {
        $hrTType = DB::table('hrtransaction_type')->select('transactionTypeCode', 'transactionTypeName')
            ->where('companyId', '=', $idCompany)
            ->orderBy('transactionTypeCode')
            ->get();
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
        $countryId = session('countryId');
        $companyId = session('companyId');
        $process->countryId = $countryId;
        $process->companyId = $companyId;
        $process->processCode = $request->processCode;
        $process->processName = $request->processName;
        $process->payrollCategory = $request->payrollCategory;
        $process->save();
        return $process;
    }
    public function storeDetail(Request $request)
    {
        // return $request;
        $processDetail = new ProcessDetail();
        $processDetail->hrprocessId = $request->hrprocessId;
        $processDetail->transactionTypeCode = $request->transactionTypeCode;
        $processDetail->quantity = $request->quantity;
        $processDetail->amount = $request->amount;
        $processDetail->params = $request->params;
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
        // $process->processCode = $request->processCode;
        $process->processName = $request->processName;
        $process->payrollCategory = $request->payrollCategory;
        
        $process->save();
        return $process;
    }
    public function updateDetail(Request $request, $id)
    {
        
        $processDetail = ProcessDetail::find($id);
        $processDetail->transactionTypeCode = $request->transactionTypeCode;
        $processDetail->quantity = $request->quantity;
        $processDetail->amount = $request->amount;
        $processDetail->params = $request->params;
        
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
        // $process = DB::select("SELECT hrprocess_detail.hrpdId FROM `hrprocess`
        // INNER JOIN hrprocess_detail ON hrprocess.hrprocessId = hrprocess_detail.hrprocessId
        // WHERE hrprocess.hrprocessId =" . $id);
        // // print_r($process);
        // // return $process;
        // if (count($process) > 0) {
        //      return true;
        // } else {
        //      return false;
        // }
        
        // $process = Process::find($id);
        // $process->delete();
    
    }
    public function destroyDetail($id)
    {
        // return 'entro';
        $process = ProcessDetail::find($id);
        $process->delete();
    
    }
}
