<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PayrollVacation extends Model
{
    public $timestamps = false;

    protected $table      = 'hrpayroll_control';
    protected $primaryKey = 'hrpayrollControlId';

    protected $fillable = ['countryId', 'companyId', 'payrollTypeId', 'year', 'payrollNumber','payrollName', 'processCode'];
    
    function getVacationList()
    {
        $countryId = session('countryId');
        $companyId = session('companyId');
        $payrollControl = DB::select("SELECT hrpayroll_control.hrpayrollControlId, country.countryId, country.countryName, company.companyId, company.companyName,
                payroll_type.payrollTypeId, payroll_type.payrollTypeName, hrpayroll_control.year, hrpayroll_control.payrollNumber,
                hrpayroll_control.payrollName, hrpayroll_control.processCode
                FROM `hrpayroll_control`
            INNER JOIN country ON hrpayroll_control.countryId = country.countryId
            INNER JOIN company ON hrpayroll_control.companyId = company.companyId
            INNER JOIN payroll_type ON hrpayroll_control.payrollTypeId = payroll_type.payrollTypeId
            WHERE hrpayroll_control.countryId = $countryId
            AND hrpayroll_control.companyId = $companyId
            AND hrpayroll_control.payrollCategory = 'vacation'
            ORDER BY hrpayroll_control.companyId");
        return $payrollControl;
    }

    // get data form table hrpayroll_control
    function getProcessPreVacations($id){
        $preVacationProcess = DB::select("SELECT * FROM hrpayroll_control
            WHERE hrpayrollControlId = " . $id);
        return $preVacationProcess;
    }

     // verifico si los datos recividos existen en la tabla hrpayroll
    function checkDataduplicate($obj){
        $rsDel0 = DB::select("SELECT COUNT(*) AS cant
            FROM hrpayroll 
                WHERE hrpayroll.countryId = $obj->countryId 
                AND hrpayroll.companyId = $obj->companyId 
                AND hrpayroll.year = $obj->year
                AND hrpayroll.payrollNumber = $obj->payrollNumber ");
        return $rsDel0;
    }

     // si los datos ya existen, los elimino para posteriormente agregar los nuevos datos
    function delDataDuplicate($obj){
        DB::table('hrpayroll')
            ->where('hrpayroll.countryId', '=', $obj->countryId)
            ->where('hrpayroll.companyId', '=', $obj->companyId)
            ->where('hrpayroll.year', '=', $obj->year)
            ->where('hrpayroll.payrollNumber', '=',  $obj->payrollNumber)
            ->delete();
    }

    // get data from table hrstaff 
    // los empleados son seleccionados por fecha de ingreso. y comparados con el periodo seleccionado 
    // para identificar que empleados seran seleccionados para las vacaciones
    function getStaffByEmploymentDate($period, $payrollTypeId){
        $countryId = session('countryId');
        $companyId = session('companyId');
        $periodFrom = $period['periodFrom'];
        $periodTo = $period['periodTo'];
        $periodYear = $period['year'];

        $rs1  = DB::select("SELECT hrstaff.*
            FROM hrstaff 
            INNER JOIN hrposition ON hrstaff.positionCode = hrposition.positionCode
            WHERE hrstaff.countryId = $countryId 
                AND hrstaff.companyId  = $companyId 
                AND hrstaff.payrollTypeId = $payrollTypeId
                AND hrstaff.status = 'A'");

        $temStaff = array();
        foreach ($rs1 as $key => $vStaff) {
            // manipulo la fecha de ingreso del emplado para saber si ya tiene el año o mas de 1 año
            $employmentDate = Carbon::createFromFormat('Y-m-d', $vStaff->employmentDate);
            $validity = $employmentDate->diffInYears($periodTo);
            if ($validity > 0) {
                // si el empleado ya tiene 1 año o mas
                // manipulo la fecha de ingreso del empleado y la coloco en el año actual 
                // para poderla compara posteriormente con el rango de fecha del periodo actual entre periodFrom y periodTo
                // para poder identificar los meses y dias del periodo, con el mes y dia de ingreso de la persona
                // ej: fecha de ingreso, con el año actual = 2021-06-03, 
                // periodFrom = 2021-06-01
                // periodTo = 2021-06-15
                // if(2021-06-03 >= 2021-06-01 && 2021-06-03 <= 2021-06-15)
                $tempEmploymentDate =  "$periodYear".substr($vStaff->employmentDate, 4);
                if ($tempEmploymentDate >= $periodFrom && $tempEmploymentDate <= $periodTo) {
                    $temStaff[] = [
                        'payrollTypeId' =>  $vStaff->payrollTypeId,
                        'employmentDate' =>  $vStaff->employmentDate,
                        "hrstaffId" => $vStaff->hrstaffId,
                        "countryId" => $vStaff->countryId,
                        "companyId" => $vStaff->companyId,
                        "payrollTypeId" => $vStaff->payrollTypeId,
                        "staffCode" => $vStaff->staffCode,
                        "firstName" => $vStaff->firstName,
                        "lastName" => $vStaff->lastName,
                        "shortName" => $vStaff->shortName,
                        "idDocument" => $vStaff->idDocument,
                        "passportNumber" => $vStaff->passportNumber,
                        "legalNumber" => $vStaff->legalNumber,
                        "departmentId" => $vStaff->departmentId,
                        "positionCode" => $vStaff->positionCode,
                        "employmentDate" => $vStaff->employmentDate,
                        "birthdayDate" => $vStaff->birthdayDate,
                        "childrenCount" => $vStaff->childrenCount,
                        "probationPeriod" => $vStaff->probationPeriod,
                        "probationPeriodEnd" => $vStaff->probationPeriodEnd,
                        "baseSalary" => $vStaff->baseSalary,
                        "retentionSalary" => $vStaff->retentionSalary,
                        "baseCurrencyId" => $vStaff->baseCurrencyId,
                        "localSalary" => $vStaff->localSalary,
                        "probationSalary" => $vStaff->probationSalary,
                        "stopSS" => $vStaff->stopSS,
                        "blockSS" => $vStaff->blockSS,
                        "localCurrencyId" => $vStaff->localCurrencyId,
                        "localDailySalary" => $vStaff->localDailySalary,
                        "excTranTypeCode1" => $vStaff->excTranTypeCode1,
                        "excTranTypeCode2" => $vStaff->excTranTypeCode2,
                        "excTranTypeCode3" => $vStaff->excTranTypeCode3,
                        "status" => $vStaff->status,
                        "number" => $vStaff->number,
                        "deleted_at" => $vStaff->deleted_at,
                        "tempEmploymentDate" => $tempEmploymentDate,
                        "periodFrom" => $periodFrom,
                        "periodTo" => $periodTo,
                        "validity" => $validity,
                    ];
                }
            }
        }
        return $temStaff;
    }

    // funcion para calcular dias feriados entre dos fechas
    function weekend($period) {
        
        $periodFrom = $period['periodFrom'];
        $periodTo = $period['periodTo'];
        $holiday1 = $period['holiday1'];
        $holiday2 = $period['holiday2'];
        $holiday3 = $period['holiday3'];
        $holiday4 = $period['holiday4'];
        $holiday5 = $period['holiday5'];
        $periodFrom = Carbon::parse($periodFrom);
        $days = $periodFrom->diffInDays($periodTo); //calcila la diferencia de dias entre periodFrom y periodTo
        // $periodFrom1 = Carbon::createFromFormat('Y-m-d', $periodFrom1)->addDay()->toDateTimeString();
        // $periodFrom1 = $periodFrom->addDay();
        $dayOff = 0;
        for ($i=1; $i <=$days ; $i++) { 
            $dayL = strtoupper(substr($periodFrom->format('l'), 0, 2)); // dia en letra
            $dayN = strtoupper(substr($periodFrom->format('d'), 0, 2)); // dia en numero
            // si es sabado o domingo, sumo un dia feriado
            if ($dayL == 'SA' || $dayL == 'SU') {
                $dayOff += 1;
            }
            // si en un dia feriado, pero no es sabado, ni domingo, sumo un dia feriado
            if ($dayN == $holiday1 || $dayN == $holiday2 || $dayN == $holiday3 || $dayN == $holiday4 || $dayN == $holiday5) {
                if ($dayL != 'SA' && $dayL != 'SU') {
                    $dayOff += 1;
                }
            }
            $periodFrom->addDay();
        }
        // dd($dayOff);
        return $dayOff;
    }
}
