<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\hrPrinPayroll;
use App\Models\Config_report\Config_report;

class printPayrollController extends Controller
{
    private $oGetPayroll;
    private $oHeaderPayroll;
    private $oDetailPayroll;
    private $oConfigReport;
    
    function __construct()
    {
        $this->oGetPayroll = new hrPrinPayroll;
        $this->oHeaderPayroll = new hrPrinPayroll;
        $this->oDetailPayroll = new hrPrinPayroll;
        $this->oReporteByTransaction = new hrPrinPayroll();
        $this->oConfigReport = new Config_report;
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
    
    public function getPayrollShow($countryId, $companyId, $year, $payrollNumber, $payrollTypeId, $payrollCategory="payroll")
    {

        // obtiener informacion para los encabezados 
        $res0 = $this->oHeaderPayroll->headerPayroll($countryId, $companyId, $year, $payrollNumber, $payrollTypeId, $payrollCategory="payroll");
        // dd($res0);
        if (empty($res0)) {
            return response()->json(['message' => 'no content'], 204);
            // exit();
        }
        // obtengo los datos de configuracion para el reporte
        $configReport = $this->oConfigReport->getConfigReportByCompany($countryId, $companyId,'payroll');

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
        $print[9]  = $configReport;
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

    // imprimir todas las vacaciones de un periodo
    public function getVacationShow($year, $payrollNumber, $payrollTypeId, $payrollCategory)
    {

        // obtiener informacion para los encabezados 
        $res0 = $this->oHeaderPayroll->headerPayrollVacation($year, $payrollNumber, $payrollTypeId, $payrollCategory);
        $countryId = session('countryId');
        $companyId = session('companyId');
        // obtengo los datos de configuracion para el reporte
        $configReport = $this->oConfigReport->getConfigReportByCompany($countryId, $companyId,'vacation');

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
        $print[9]  = $configReport;
        $print[10] = $res0[0]->color;
        $print[11] = $res0[0]->totalasignacionLocal;
        $print[12] = $res0[0]->totaldeduccionLocal;
        $print[13] = $res0[0]->userProcess;

        // Obtener los detalles de las vacaciones
        foreach($res0 as $res1){
            
            $print[] = $this->oDetailPayroll->detailPayrollVacation($year, $payrollNumber, $res1->staffCode, $payrollCategory);
                            // return  $print;
        }                    
        //  dd($print);
        // return $print;
    
        return compact('print');
    }
    // imprimir las vacaciones de un empleado
    public function getVacationEmployees($year, $payrollNumber, $payrollTypeId, $payrollCategory, $staffCode)
    {

        // obtiener informacion para los encabezados 
        $res0 = $this->oHeaderPayroll->headerPayrollVacationStaff($year, $payrollNumber, $payrollTypeId, $payrollCategory, $staffCode);
        if (empty($res0)) {
            return response()->json([], 204);
        }

        $countryId = session('countryId');
        $companyId = session('companyId');
        // obtengo los datos de configuracion para el reporte
        $configReport = $this->oConfigReport->getConfigReportByCompany($countryId, $companyId,'vacatstaff');

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
        $print[9]  = $configReport;
        $print[10] = $res0[0]->color;
        $print[11] = $res0[0]->totalasignacionLocal;
        $print[12] = $res0[0]->totaldeduccionLocal;
        $print[13] = $res0[0]->userProcess;
        
        // Obtener los detalles de las vacaciones
        foreach($res0 as $res1){
            
            $print[] = $this->oDetailPayroll->detailPayrollVacation($year, $payrollNumber, $staffCode, $payrollCategory);
            // return  $print;
        }                    
        //  dd($print);
        // return $print;
    
        return compact('print');
    }

    public function reportByTransactionPayrollController(Request $request)
    {
        // echo $request->payrollNumber;
        $res0 = $this->oReporteByTransaction->reportByTransactionPayroll($request->countryId, $request->companyId, $request->payrollNumber,$request->transaction, $request->employees, $request->table, $request->report);

        return response()->json(['data' => $res0],200);
    }
}
