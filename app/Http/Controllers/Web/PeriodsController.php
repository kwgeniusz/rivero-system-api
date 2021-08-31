<?php

namespace App\Http\Controllers\web;

use App\Periods;
use App\Country;
use App\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PeriodsController extends Controller
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
        $periods = DB::select("SELECT  hrperiod.periodId, hrperiod.`countryId`, hrperiod.`companyId`, hrperiod.`year`,
                        hrperiod.`payrollTypeId`, hrperiod.`payrollNumber`,hrperiod.`periodName`, hrperiod.`periodFrom`, hrperiod.`periodTo`, hrperiod.`updated`,
                        country.countryId, country.countryName,
                        company.companyId, company.companyShortName,
                        payroll_type.payrollTypeId, payroll_type.payrollTypeName
                    FROM
                        `hrperiod`
                    INNER JOIN country ON hrperiod.countryId = country.countryId
                    INNER JOIN company ON hrperiod.companyId = company.companyId
                    INNER JOIN payroll_type ON hrperiod.payrollTypeId = payroll_type.payrollTypeId
                    WHERE hrperiod.countryId = $countryId
                    AND hrperiod.companyId = $companyId");

        $companys =  Company::select('companyShortName', 'companyId')->get();
       
        $countrys = DB::table('country')->select('countryId', 'countryName')->get();
        $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')->get();
       
        // $countrys   = $this->oCountry->getAll();
        return compact('countrys','periods', 'companys', 'payrollType');
    }
    
    
    /** FUNCION PARA OBTENER TIPO DE NOMINA */
    
    function getPayrollType()
    {
        $countryId = session('countryId');
        $payrollType = DB::table('payroll_type')->select('payrollTypeId', 'payrollTypeName')
            ->where('countryId','=', $countryId)
            ->get();
        return $payrollType;
    }

    function getPayrollNumber($country, $company, $payrollType, $year)
    {
        // return $country . ' ' . $company. ' '. $payrollType .' '. $year;

        $payrollTypeMax = DB::select("SELECT MAX(`payrollNumber`) AS payrollNumber FROM `hrperiod` 
                            WHERE `countryId`= $country AND `companyId`= $company AND `year`= $year AND`payrollTypeId` = $payrollType");

        return $payrollTypeMax;
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
        $periods = new Periods();
        $periods->countryId = session('countryId');
        $periods->companyId = session('companyId');
        $periods->year = $request->year;
        $periods->payrollTypeId = $request->payrollTypeId;
        $periods->payrollNumber = $request->payrollNumber;
        $periods->periodName = $request->periodName;
        $periods->periodFrom = $request->periodFrom;
        $periods->periodTo = $request->periodTo;
        $periods->updated = $request->updated;
        $periods->save();
        return $periods;
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
        
        $periods = Periods::find($id);
        $periods->countryId = $request->countryId;
        $periods->companyId = $request->companyId;
        $periods->year = $request->year;
        $periods->payrollTypeId = $request->payrollTypeId;
        $periods->payrollNumber = $request->payrollNumber;
        $periods->periodName = $request->periodName;
        $periods->periodFrom = $request->periodFrom;
        $periods->periodTo = $request->periodTo;
        $periods->updated = $request->updated;
        
        $periods->save();
        return $periods;
    }

    public function getPeriodReport($countryId, $companyId, $periodFrom, $periodTo, $updated)
    {
        $payrollNumber = DB::table('hrperiod')->select('payrollNumber')
        ->where('periodFrom' , '>=' , $periodFrom)
        ->where('periodTo' , '<=' , $periodTo)
        ->where('countryId' , '=' , $countryId)
        ->where('companyId' , '=' , $companyId)
        ->where('updated' , '=' , $updated)
        ->first();
        // ->collapse();

        // $payrolNumber1 = collect($payrollNumber)->values();


        return response()->json(["payrollNumber" =>  $payrollNumber],200);
    }

     // script usado para generar los periodos automaticos.. 
    // actatualmente solo se usa bajo desarrollo para pruebas masivas
    function generatePeriods($year,$month){
        // echo $year.$month;
        $year;
        $month;
        
        $countryId = 2;
        $companyId = 5;
        $payrollTypeId = 4;
        $payrollNumber = 1;
        $periodName ='';
        $periodFrom = '';
        $periodTo ='';
        // $yearMonth    = "{$year}-{$month}";

        $monthName = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");

        // echo $monthName[date('n')-1];
        
        for ($i=1; $i <= 12; $i++) { 
            
            // para primera quincena
            $yearMonth    = "{$year}-{$month}";
            $fromPrimeraQuincena  = date('Y-m-d', strtotime("{$yearMonth}"));
            $toPrimeraQuincena     = date('Y-m-d', strtotime("{$yearMonth} + 14 day"));
            // echo '1era Quincena '.$monthName[$month-1];
            
            
            // para segunda quincena
            $fromSegundaQuincena     = date('Y-m-d', strtotime("{$yearMonth} + 15 day"));
            $auxPrimeraQuincena  = date('Y-m-d', strtotime("{$yearMonth} + 1 month"));
            $toSegundaQuincena     = date('Y-m-d', strtotime("{$auxPrimeraQuincena} - 1 day"));

            $periods = new Periods();
            $periods->countryId = $countryId;
            $periods->companyId = $companyId;
            $periods->year = $year;
            $periods->payrollTypeId = $payrollTypeId;
            $periods->payrollNumber = $payrollNumber;
            $periods->periodName = '1era Quincena '.$monthName[$month-1].' '.$year.' ';
            $periods->periodFrom = $fromPrimeraQuincena;
            $periods->periodTo = $toPrimeraQuincena;
            $periods->updated = 0;
            $periods->save();

            $periods = new Periods();
            $periods->countryId = $countryId;
            $periods->companyId = $companyId;
            $periods->year = $year;
            $periods->payrollTypeId = $payrollTypeId;
            $periods->payrollNumber = $payrollNumber + 1;
            $periods->periodName = '2da Quincena '.$monthName[$month-1].' '.$year.' ';
            $periods->periodFrom = $fromSegundaQuincena;
            $periods->periodTo = $toSegundaQuincena;
            $periods->updated = 0;
            $periods->save();

            $payrollNumber = $payrollNumber + 2;
            // return $periods;
            // echo $ToPrimeraQuincena ."<br>";
            // echo $segundaQuincena ."<br>";
            $month = $month + 1;
        }
        // echo date('M', strtotime("{$yearMonth} + 14 day"));;
        return 'success';
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
}
