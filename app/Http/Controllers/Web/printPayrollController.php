<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\hrPrinPayroll;

class printPayrollController extends Controller
{
    private $oGetPayroll;
    private $oHeaderPayroll;
    private $oDetailPayroll;
    
    function __construct()
    {
        $this->oGetPayroll = new hrPrinPayroll;
        $this->oHeaderPayroll = new hrPrinPayroll;
        $this->oDetailPayroll = new hrPrinPayroll;
        $this->oReporteByTransaction = new hrPrinPayroll();
    }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return $this->oGetPayroll->getPayrollList();
    }
    
    public function getPayrollShow($countryId, $companyId, $year, $payrollNumber, $payrollTypeId)
    {

        // obtiener informacion para los encabezados 
        $res0 = $this->oHeaderPayroll->headerPayroll($countryId, $companyId, $year, $payrollNumber, $payrollTypeId);
 
        $print = array();
        $print[0]  = $res0[0]->payrollName;
        $print[1]  = $res0[0]->countryName;
        $print[2]  = $res0[0]->companyShortName;
        $print[3]  = $res0[0]->logo;
        $print[4]  = $res0[0]->payrollTypeName;
        $print[5]  = $res0[0]->totalasignacion;
        $print[6]  = $res0[0]->totaldeduccion;
        $print[7]  = $res0[0]->companyAddress;
        $print[8]  = $res0[0]->companyNumber;
        $print[9]  = $res0[0]->companyId;
        $print[10] = $res0[0]->color;
        $print[11] = $res0[0]->totalasignacionLocal;
        $print[12] = $res0[0]->totaldeduccionLocal;
        $print[13] = $res0[0]->userProcess;

        // Obtener los detalles de la Nomina
        foreach($res0 as $res1){
            
            $print[] = $this->oDetailPayroll->detailPayroll($countryId, $companyId, $year, $payrollNumber, $res1->staffCode);
                            // return  $print;
        }                    
        //  dd($print);
        // return $print;
    
        return compact('print');
    }

    public function reportByTransactionPayrollController(Request $request)
    {
        // echo $request->payrollNumber;
        $res0 = $this->oReporteByTransaction->reportByTransactionPayroll($request->countryId, $request->companyId, $request->payrollNumber,$request->transaction, $request->employees, $request->table);

        return response()->json(['data' => $res0],200);
    }
   
   
}
