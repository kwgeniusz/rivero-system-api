<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CompanyConfiguration;
use App\Models\Accounting\GeneralLedgerBalance;

class GeneralLedgerBalance extends Model
{
   //traits
    use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'acc_general_ledger_balance';
    protected $primaryKey = 'generalLedgerBalanceId';

    protected $fillable = ['generalLedgerBalanceId','generalLedgerId','year','currencyId','initialDebit','initialCredit','debit01','credit01','debit02','credit02','debit03','credit03','debit04','credit04','debit05','credit05','debit06','credit06','debit07','credit07','debit08','credit08','debit09','credit09','debit10','credit10','debit11','credit11','debit12','credit12'];
    // protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    // public function accountType()
    // {
    //     return $this->hasOne(AccountType::class, 'accountTypeCode', 'accountTypeCode');
    // }
    // public function accountClassification()
    // {
    //     return $this->hasOne(AccountClassification::class, 'accountClassificationCode', 'accountClassificationCode');
    // }
    // public function daughterAccount()
    // {
    //     return $this->hasMany(GeneralLedger::class, 'parentAccountId', 'generalLedgerId');
    // }
    // public function allDaughterAccount()
    // {
    //     return $this->daughterAccount()->with('allDaughterAccount');
    // } 
//--------------------------------------------------------------------
     /** ACCESORES **/
//--------------------------------------------------------------------
   
//    public function getTransactionDateAttribute($transactionDate)
//    {
//         $oDateHelper = new DateHelper;
//         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
//         $newDate    = $oDateHelper->$functionRs($transactionDate);
//        return $newDate;
//    }
 //--------------------------------------------------------------------
     /** MUTADORES **/
//--------------------------------------------------------------------
//    public function setClientNameAttribute($clientName)
//    {
//     $clientName = strtolower($clientName);
//     $clientName = ucwords($clientName);

//      return $this->attributes['clientName'] = ucwords($clientName);
//    }
//--------------------------------------------------------------------
    /** Query Scope  */
//--------------------------------------------------------------------
    // nombre codigo direccion
    // public function scopeFilter($query, $filteredOut)
    // {
    //     if ($filteredOut) {
    //         return $query->where('clientCode', 'LIKE', "%$filteredOut%")
    //                      ->orWhere('clientName', 'LIKE', "%$filteredOut%")
    //                      ->orWhere('businessPhone', 'LIKE', "%$filteredOut%")
    //                      ->orWhere('mainEmail', 'LIKE', "%$filteredOut%")
    //                      ->orWhereHas('company', function ($query) use ($filteredOut) {
    //                           return $query->where('companyName', 'LIKE', "%$filteredOut%");
    //                       });
    //     }
    // }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
 function getByYear($accYear){
       return $this->where('year', '=', $accYear)
                   ->get();
}
// =========================================================================  
function closeYear(){
   
   $error = null;
   
   DB::beginTransaction();
   try {
      
      $oCompanyConfig           = new CompanyConfiguration;
      $oGeneralLedger           = new GeneralLedger;
      $oGeneralLedgerBalance    = new GeneralLedgerBalance;

      $config            = $oCompanyConfig->findByCompany(session('companyId'));
      // obtengo el a#o contable actual y lo incremento
      $accYear           = $config[0]->accYear;
      $accNewYear        = $accYear + 1;
      
   // obteniendo los saldos del a#o actual para crear el saldo inicial del a#o siguiente
   $lastYearData = $oGeneralLedgerBalance->getByYear($accYear);
   
   foreach($lastYearData as $lastYear){
       $initialDebitTotal  = 0; $initialCreditTotal = 0;
       $initialDebitTotalSec  = 0; $initialCreditTotalSec = 0;

       $initialDebitTotal  = $lastYear->initialDebit + 
                             $lastYear->debit01 + 
                             $lastYear->debit02 + 
                             $lastYear->debit03 + 
                             $lastYear->debit04 +
                             $lastYear->debit05 +
                             $lastYear->debit06 +
                             $lastYear->debit07 +
                             $lastYear->debit08 + 
                             $lastYear->debit09 + 
                             $lastYear->debit10 + 
                             $lastYear->debit11 + 
                             $lastYear->debit12;

      $initialDebitTotalSec= $lastYear->initialDebitSec + 
                             $lastYear->debit01Sec + 
                             $lastYear->debit02Sec + 
                             $lastYear->debit03Sec + 
                             $lastYear->debit04Sec +
                             $lastYear->debit05Sec +
                             $lastYear->debit06Sec +
                             $lastYear->debit07Sec +
                             $lastYear->debit08Sec + 
                             $lastYear->debit09Sec + 
                             $lastYear->debit10Sec + 
                             $lastYear->debit11Sec + 
                             $lastYear->debit12Sec;

      $initialCreditTotal  = $lastYear->initialCredit + 
                             $lastYear->credit01 + 
                             $lastYear->credit02 + 
                             $lastYear->credit03 + 
                             $lastYear->credit04 +
                             $lastYear->credit05 +
                             $lastYear->credit06 +
                             $lastYear->credit07 +
                             $lastYear->credit08 + 
                             $lastYear->credit09 + 
                             $lastYear->credit10 + 
                             $lastYear->credit11 + 
                             $lastYear->credit12;

      $initialCreditTotalSec=$lastYear->initialCreditSec + 
                             $lastYear->credit01Sec + 
                             $lastYear->credit02Sec + 
                             $lastYear->credit03Sec + 
                             $lastYear->credit04Sec +
                             $lastYear->credit05Sec +
                             $lastYear->credit06Sec +
                             $lastYear->credit07Sec +
                             $lastYear->credit08Sec + 
                             $lastYear->credit09Sec + 
                             $lastYear->credit10Sec + 
                             $lastYear->credit11Sec + 
                             $lastYear->credit12Sec;

       $generalLedgerBalance                     =  new GeneralLedgerBalance;
       $generalLedgerBalance->generalLedgerId    =  $lastYear->generalLedgerId;
       $generalLedgerBalance->year	             =  $accNewYear;
       $generalLedgerBalance->currencyId         =  $lastYear->currencyId;
       $generalLedgerBalance->initialDebit       =  $initialDebitTotal;
       $generalLedgerBalance->initialCredit      =  $initialCreditTotal;
       $generalLedgerBalance->initialDebitSec    =  $initialDebitTotalSec;
       $generalLedgerBalance->initialCreditSec   =  $initialCreditTotalSec;
       $generalLedgerBalance->save();
       
        $rs = $oGeneralLedger->updateAmounts($lastYear->generalLedgerId,$initialDebitTotal,$initialCreditTotal,$initialDebitTotalSec,$initialCreditTotalSec);

      }
      
      //incrementar a#o contable.
    $oCompanyConfig->increaseAccYear(session('countryId'),session('companyId'));

       $success = true;
       DB::commit();
   } catch (\Exception $e) {
       $success = false;
       $error   = $e->getMessage();
       DB::rollback();
   }

   if ($success) {
      return $rs  = ['alert-type' => 'success', 'message' => "Se ha Cerrado el Año contable con exito."];
   } else {
       return $rs = ['alert-type' => 'error', 'message' => $error];
   }
}
// ==================================================================================
function updateBalance($generalLedgerId,$year,$month,$debit,$credit,$debitSec,$creditSec)
{
  // obtener $saldos actuales
    DB::beginTransaction();
    try {   
        $query = $this->where('generalLedgerId', '=', $generalLedgerId)
                      ->where('year','=',$year)
                      ->get();

  foreach($query as $rs){
   //  dd($rs->debit01);
      $debit01        = $rs->debit01;
      $credit01       = $rs->credit01;
      $debit02        = $rs->debit02;
      $credit02       = $rs->credit02;
      $debit03        = $rs->debit03;
      $credit03       = $rs->credit03;
      $debit04        = $rs->debit04;
      $credit04       = $rs->credit04;
      $debit05        = $rs->debit05;
      $credit05       = $rs->credit05;
      $debit06        = $rs->debit06;
      $credit06       = $rs->credit06;
      $debit07        = $rs->debit07;
      $credit07       = $rs->credit07;
      $debit08        = $rs->debit08;
      $credit08       = $rs->credit08;
      $debit09        = $rs->debit09;
      $credit09       = $rs->credit09;
      $debit10        = $rs->debit10;
      $credit10       = $rs->credit10;
      $debit11        = $rs->debit11;
      $credit11       = $rs->credit11;
      $debit12        = $rs->debit12;
      $credit12       = $rs->credit12;

      $debit01Sec        = $rs->debit01Sec;
      $credit01Sec       = $rs->credit01Sec;
      $debit02Sec        = $rs->debit02Sec;
      $credit02Sec       = $rs->credit02Sec;
      $debit03Sec        = $rs->debit03Sec;
      $credit03Sec       = $rs->credit03Sec;
      $debit04Sec        = $rs->debit04Sec;
      $credit04Sec       = $rs->credit04Sec;
      $debit05Sec        = $rs->debit05Sec;
      $credit05Sec       = $rs->credit05Sec;
      $debit06Sec        = $rs->debit06Sec;
      $credit06Sec       = $rs->credit06Sec;
      $debit07Sec        = $rs->debit07Sec;
      $credit07Sec       = $rs->credit07Sec;
      $debit08Sec        = $rs->debit08Sec;
      $credit08Sec       = $rs->credit08Sec;
      $debit09Sec        = $rs->debit09Sec;
      $credit09Sec       = $rs->credit09Sec;
      $debit10Sec        = $rs->debit10Sec;
      $credit10Sec       = $rs->credit10Sec;
      $debit11Sec        = $rs->debit11Sec;
      $credit11Sec       = $rs->credit11Sec;
      $debit12Sec        = $rs->debit12Sec;
      $credit12Sec       = $rs->credit12Sec;
// hasta el mes 12
  }

  switch ($month) { 
      case 1:
         $debit01   =  $debit01 + $debit;
         $credit01  =  $credit01 + $credit;
         $debit01Sec   =  $debit01Sec + $debitSec;
         $credit01Sec  =  $credit01Sec + $creditSec;
      break;
      case 2:
         $debit02   =  $debit02 + $debit;
         $credit02  =  $credit02 + $credit;
         $debit02Sec   =  $debit02Sec + $debitSec;
         $credit02Sec  =  $credit02Sec + $creditSec;
      break;
      case 3:
         $debit03   =  $debit03 + $debit;
         $credit03  =  $credit03 + $credit;
         $debit03Sec   =  $debit03Sec + $debitSec;
         $credit03Sec  =  $credit03Sec + $creditSec;
      break;
      case 4:
         $debit04   =  $debit04 + $debit;
         $credit04  =  $credit04 + $credit;
         $debit04Sec   =  $debit04Sec + $debitSec;
         $credit04Sec  =  $credit04Sec + $creditSec;
      break;
      case 5:
         $debit05   =  $debit05 + $debit;
         $credit05  =  $credit05 + $credit;
         $debit05Sec   =  $debit05Sec + $debitSec;
         $credit05Sec  =  $credit05Sec + $creditSec;
      break;
         case 6:
         $debit06   =  $debit06 + $debit;
         $credit06  =  $credit06 + $credit;
         $debit06Sec   =  $debit06Sec + $debitSec;
         $credit06Sec  =  $credit06Sec + $creditSec;
      break;
         case 7:
         $debit07   =  $debit07 + $debit;
         $credit07  =  $credit07 + $credit;
         $debit07Sec   =  $debit07Sec + $debitSec;
         $credit07Sec  =  $credit07Sec + $creditSec;
      break;
         case 8:
        $debit08   =  $debit08 + $debit;
        $credit08  =  $credit08 + $credit;
        $debit08Sec   =  $debit08Sec + $debitSec;
        $credit08Sec  =  $credit08Sec + $creditSec;
      break;
        case 9:
         $debit09   =  $debit09 + $debit;
         $credit09  =  $credit09 + $credit;
         $debit09Sec   =  $debit09Sec + $debitSec;
         $credit09Sec  =  $credit09Sec + $creditSec;
      break;
         case 10:
        $debit10   =  $debit10 + $debit;
        $credit10  =  $credit10 + $credit;
        $debit10Sec   =  $debit10Sec + $debitSec;
        $credit10Sec  =  $credit10Sec + $creditSec;
      break;
        case 11:
         $debit11   =  $debit11 + $debit;
         $credit11  =  $credit11 + $credit;
         $debit11Sec   =  $debit11Sec + $debitSec;
         $credit11Sec  =  $credit11Sec + $creditSec;
      break;
         case 12:
        $debit12   =  $debit12 + $debit;
        $credit12  =  $credit12 + $credit;
        $debit12Sec   =  $debit12Sec + $debitSec;
        $credit12Sec  =  $credit12Sec + $creditSec;
      break;
    // hasta el mes 12
  }
  //Actualizar saldos en tabl acc_general_ledger_balance
  foreach($query as $rs){
        $rs->debit01 = $debit01;
        $rs->credit01 = $credit01;
        $rs->debit02 = $debit02;
        $rs->credit02 = $credit02;
        $rs->debit03 = $debit03;
        $rs->credit03 = $credit03;
        $rs->debit04 = $debit04;
        $rs->credit04 = $credit04;
        $rs->debit05 = $debit05;
        $rs->credit05 = $credit05;
        $rs->debit06 = $debit06;
        $rs->credit06 = $credit06;
        $rs->debit07 = $debit07;
        $rs->credit07 = $credit07;
        $rs->debit08 = $debit08;
        $rs->credit08 = $credit08;
        $rs->debit09 = $debit09;
        $rs->credit09 = $credit09;
        $rs->debit10 = $debit10;
        $rs->credit10 = $credit10;
        $rs->debit11 = $debit11;
        $rs->credit11 = $credit11;
        $rs->debit12 = $debit12;
        $rs->credit12 = $credit12;

        $rs->debit01Sec = $debit01Sec;
        $rs->credit01Sec = $credit01Sec;
        $rs->debit02Sec = $debit02Sec;
        $rs->credit02Sec = $credit02Sec;
        $rs->debit03Sec = $debit03Sec;
        $rs->credit03Sec = $credit03Sec;
        $rs->debit04Sec = $debit04Sec;
        $rs->credit04Sec = $credit04Sec;
        $rs->debit05Sec = $debit05Sec;
        $rs->credit05Sec = $credit05Sec;
        $rs->debit06Sec = $debit06Sec;
        $rs->credit06Sec = $credit06Sec;
        $rs->debit07Sec = $debit07Sec;
        $rs->credit07Sec = $credit07Sec;
        $rs->debit08Sec = $debit08Sec;
        $rs->credit08Sec = $credit08Sec;
        $rs->debit09Sec = $debit09Sec;
        $rs->credit09Sec = $credit09Sec;
        $rs->debit10Sec = $debit10Sec;
        $rs->credit10Sec = $credit10Sec;
        $rs->debit11Sec = $debit11Sec;
        $rs->credit11Sec = $credit11Sec;
        $rs->debit12Sec = $debit12Sec;
        $rs->credit12Sec = $credit12Sec;
        $rs->save();
  }

      $success = true;
      DB::commit();
    } catch (\Exception $e) {
      $error   = $e->getMessage();
      $success = false;
      DB::rollback();
    }

    if ($success) {
      return $result = ['alert-type' => 'success', 'message' => 'Mes Actualizado del Libro Mayor'];
    } else {
      return $result = ['alert-type' => 'error', 'message' => $error];
    }

 }//end function

  
}//end of the class
