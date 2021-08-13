<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
function updateBalance($generalLedgerId,$year,$month,$debit,$credit)
{
  // obtener $saldos actuales
           
    DB::beginTransaction();
    try {   
        $query = $this->where('generalLedgerId', '=', $generalLedgerId)
                      ->where('year','=',$year)
                      ->get();

//   $query =  "SELECT * FROM acc_general_ledger_balance 
//                     WHERE generalLedgerId = $generalLedgerId and
//                           year            = $year";

//   foreach($query as $rs){
    // dd($query);
      $debit01        = $query->debit01;
      $credit01       = $query->credit01;
      $debit02        = $query->debit02;
      $credit02       = $query->credit02;
      $debit03        = $query->debit03;
      $credit03       = $query->credit03;
      $debit04        = $query->debit04;
      $credit04       = $query->credit04;
      $debit05        = $query->debit05;
      $credit05       = $query->credit05;
      $debit06        = $query->debit06;
      $credit06       = $query->credit06;
      $debit07        = $query->debit07;
      $credit07       = $query->credit07;
      $debit08        = $query->debit08;
      $credit08       = $query->credit08;
      $debit09        = $query->debit09;
      $credit09       = $query->credit09;
      $debit10        = $query->debit10;
      $credit10       = $query->credit10;
      $debit11        = $query->debit11;
      $credit11       = $query->credit11;
      $debit12        = $query->debit12;
      $credit12       = $query->credit12;
// hasta el mes 12
//   }

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
        $query->debit01 = $debit01;
        $query->credit01 = $credit01;
        $query->debit02 = $debit02;
        $query->credit02 = $credit02;
        $query->debit03 = $debit03;
        $query->credit03 = $credit03;
        $query->debit04 = $debit04;
        $query->credit04 = $credit04;
        $query->debit05 = $debit05;
        $query->credit05 = $credit05;
        $query->debit06 = $debit06;
        $query->credit06 = $credit06;
        $query->debit07 = $debit07;
        $query->credit07 = $credit07;
        $query->debit08 = $debit08;
        $query->credit08 = $credit08;
        $query->debit09 = $debit09;
        $query->credit09 = $credit09;
        $query->debit10 = $debit10;
        $query->credit10 = $credit10;
        $query->debit11 = $debit11;
        $query->credit11 = $credit11;
        $query->debit12 = $debit12;
        $query->credit12 = $credit12;
        $query->save();
// = $flight   $query =  "UPDATE acc_general_ledger_balance 
//                     SET 
//                     WHERE generalLedgerId = $generalLedgerId and
//                           year            = $year";

      $success = true;
      DB::commit();
    } catch (\Exception $e) {
      $error   = $e->getMessage();
      $success = false;
      DB::rollback();
    }

    if ($success) {
    return $result = ['alert-type' => 'success', 'message' => 'Operacion Realizada'];
    } else {
    return $result = ['alert-type' => 'error', 'message' => $error];
    }



 }//end function

}//end of the class
