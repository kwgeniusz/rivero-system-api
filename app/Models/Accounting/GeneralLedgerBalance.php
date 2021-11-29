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
    //     return $this->hasMany(GeneralLedger::class, 'parentAccountCode', 'accountCode');
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

   $oCompanyConfig    = new CompanyConfiguration;
   $config            = $oCompanyConfig->findByCompany(session('companyId'));
   $accYear           = $config[0]->accYear;
   $accNewYear        = $accYear + 1;
   
   $oGeneralLedgerBalance    = new GeneralLedgerBalance;
   $lastYearData = $oGeneralLedgerBalance->getByYear($accYear);
   
   foreach($lastYearData as $lastYear){
       $initialDebitTotal  = 0; $initialCreditTotal = 0;

       $initialDebitTotal  = $lastYear->debit01 + 
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

      $initialCreditTotal  = $lastYear->credit01 + 
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

       $generalLedgerBalance                     =  new GeneralLedgerBalance;
       $generalLedgerBalance->generalLedgerId    =  $lastYear->generalLedgerId;
       $generalLedgerBalance->year	              =  $accNewYear;
       $generalLedgerBalance->currencyId         =  $lastYear->currencyId;
       $generalLedgerBalance->initialDebit       =  $initialDebitTotal;
       $generalLedgerBalance->initialCredit      =  $initialCreditTotal;
       $generalLedgerBalance->save();
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
function updateBalance($generalLedgerId,$year,$month,$debit,$credit)
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
// hasta el mes 12
  }

  switch ($month) { 
      case 1:
         $debit01   =  $debit01 + $debit;
         $credit01  =  $credit01 + $credit;
      break;
      case 2:
         $debit02   =  $debit02 + $debit;
         $credit02  =  $credit02 + $credit;
      break;
      case 3:
         $debit03   =  $debit03 + $debit;
         $credit03  =  $credit03 + $credit;
      break;
      case 4:
         $debit04   =  $debit04 + $debit;
         $credit04  =  $credit04 + $credit;
      break;
      case 5:
         $debit05   =  $debit05 + $debit;
         $credit05  =  $credit05 + $credit;
      break;
         case 6:
         $debit06   =  $debit06 + $debit;
         $credit06  =  $credit06 + $credit;
      break;
         case 7:
         $debit07   =  $debit07 + $debit;
         $credit07  =  $credit07 + $credit;
      break;
         case 8:
        $debit08   =  $debit08 + $debit;
        $credit08  =  $credit08 + $credit;
      break;
        case 9:
         $debit09   =  $debit09 + $debit;
         $credit09  =  $credit09 + $credit;
      break;
         case 10:
        $debit10   =  $debit10 + $debit;
        $credit10  =  $credit10 + $credit;
      break;
        case 11:
         $debit11   =  $debit11 + $debit;
         $credit11  =  $credit11 + $credit;
      break;
         case 12:
        $debit12   =  $debit12 + $debit;
        $credit12  =  $credit12 + $credit;
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
