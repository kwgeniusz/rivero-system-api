<?php

namespace App\Models\Accounting;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralLedger extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'acc_general_ledger';
    protected $primaryKey = 'generalLedgerId';

    protected $fillable = ['generalLedgerId','countryId' ,'companyId','accountCode','accountName','leftMargin','parentAccountCode','accountClassificationCode', 'accountTypeCode','debit','credit'];
    // protected $dates = ['deleted_at'];

    // Type Of Account
    const TOTAL          = '1';
    const TRANSACTION    = '2';

//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    public function accountType()
    {
        return $this->hasOne(AccountType::class, 'accountTypeCode', 'accountTypeCode');
    }
    public function accountClassification()
    {
        return $this->hasOne(AccountClassification::class, 'accountClassificationCode', 'accountClassificationCode');
    }
    public function daughterAccount()
    {
        return $this->hasMany(GeneralLedger::class, 'parentAccountCode', 'accountCode');
    }
    public function allDaughterAccount()
    {
        return $this->daughterAccount()->with('allDaughterAccount');
    } 
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
    public function findById($id)
    {
        return $this->where('generalLedgerId', '=', $id)
                    ->get();
    }

    public function getAllByCompany($companyId) 
    {  
         return $this->with('accountType','accountClassification')
                     ->where('companyId', '=', $companyId)
                     ->orderBy('accountCode', 'ASC')
                     ->get(); 
     }      
     public function getAllByType($companyId,$accountTypeCode) 
     {  
          return $this->with('accountType','accountClassification')
                      ->where('companyId', '=', $companyId)
                      ->where('accountTypeCode', '=', $accountTypeCode)
                      ->orderBy('accountCode', 'ASC')
                      ->get(); 
      }      
    public function insertG($countryId, $companyId, $data)
    {
          $error = null;
    
     DB::beginTransaction();
      try {
   
        $generalLedger                          = new GeneralLedger;
        $generalLedger->countryId               = $countryId;
        $generalLedger->companyId               = $companyId;
        $generalLedger->accountCode             = $data['accountCode'];
        $generalLedger->accountName             = $data['accountName'];
        $generalLedger->leftMargin              = $data['leftMargin'];
        $generalLedger->parentAccountCode       = $data['parentAccountCode'];
        $generalLedger->accountClassificationCode   = $data['accountClassificationCode'];
        $generalLedger->accountTypeCode         = $data['accountTypeCode'];
        $generalLedger->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Cuenta Creada Exitosamente."];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }

    }
//------------------------------------------
    public function updateG($companyId,$generalLedgerId ,$data)
    {
          $error = null;

     DB::beginTransaction();
      try {

        $generalLedger                          = GeneralLedger::find($generalLedgerId);
        $generalLedger->accountCode                 = $data['accountCode'];
        $generalLedger->accountName                 = $data['accountName'];
        $generalLedger->leftMargin                  = $data['leftMargin'];
        $generalLedger->parentAccountCode           = $data['parentAccountCode'];
        $generalLedger->accountClassificationCode   = $data['accountClassificationCode'];
        $generalLedger->accountTypeCode             = $data['accountTypeCode'];
        $generalLedger->save();
        
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Cuenta Modificada"];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteG($companyId,$generalLedgerId)
    {
        try {
          $this->where('companyId', '=', $companyId)
               ->where('generalLedgerId', '=', $generalLedgerId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Cuenta Eliminada'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
function cascadeBalanceUpdate($countryId,$companyId,$generalLedgerId,$debit,$credit,$year,$month)
{

  
    DB::beginTransaction();
    try {    
  // obtener $accountCode
  $accountCode = '';
  $query  = $this->find($generalLedgerId);
//   $query =  "SELECT * FROM acc_general_ledger WHERE generalLedgerId = $generalLedgerId";

      $accountCode = $query->accountCode;
      if (empty($query->parentAccountCode)) {
         $parentAccountCode = "";
      } else {
         $parentAccountCode = $query->parentAccountCode;
      }

    //   dd($query->accountCode);
  // actualizar saldo en cascada
  $loop = 1;
  // inicio del loop
  while($loop == 1) {
    // echo "VALORES:$generalLedgerId.$year.$month.$debit.$credit";

     // actualizar el saldo de cuenta con $generalLedgerId
     $oGeneralLedgerBalance->updateBalance($generalLedgerId,$year,$month,$debit,$credit);

        dd($oGeneralLedgerBalance);
        exit();
      // siguiente nivel arriba
      $generalLedgerId = 0;

      $query =  $this->where('countryId','=', $generalLedgerId)
                     ->where('countryId','=',$countryId)
                     ->where('countryId','=',$companyId)
                     ->where('accountCode','=',$parentAccountCode)
                     ->get();
                     
        //   dd($query);
        //   exit();           
                //      "SELECT * FROM acc_general_ledger 
                //    WHERE countryId         = $countryId and  
                //          companyId         = $companyId and 
                //          accountCode       = $parentAccountCode";

      foreach($query as $rs){
          $generalLedgerId    = $rs->generalLedgerId;
          $accountCode        = $rs->accountCode;
          if (empty($rs->parentAccountCode)) {
             $parentAccountCode = "";
          } else {
             $parentAccountCode  = $rs->parentAccountCode;
          }
      }

      // condicion de salida del ciclo while
      if ($generalLedgerId == 0 ) {
         $loop = 0;
      }

    }//end of the loop
    // $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Cuenta Eliminada'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
  }//end of the function
//------------------------------------------
function updateBalance($generalLedgerId,$year,$month,$debit,$credit)
{
  // obtener $saldos actuales
           
    DB::beginTransaction();
    try {   

        // dd($generalLedgerId);
        // exit();
        $query = $this->where('generalLedgerId', '=', $generalLedgerId)
                   ->where('year','=',$year)
                   ->get();

//   $query =  "SELECT * FROM acc_general_ledger_balance 
//                     WHERE generalLedgerId = $generalLedgerId and
//                           year            = $year";

dd($query);
  foreach($query as $rs){
      $debit01        = $rs->debit01;
      $credit01       = $rs->credit01;
      $debit02        = $rs->debit02;
      $credit02       = $rs->credit02;
      $debit03        = $rs->debit03;
      $credit03       = $rs->credit03;
      $debit04        = $rs->debit04;
      $credit04       = $rs->credit04;
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
  $query =  "UPDATE acc_general_ledger_balance 
                    SET 
                    WHERE generalLedgerId = $generalLedgerId and
                          year            = $year";

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
