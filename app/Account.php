<?php

namespace App;

use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;

    protected $table      = 'account';
    protected $primaryKey = 'accountId';
    protected $fillable   = [
        'countryId',
        'bankName',
    ];
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function bank()
    {
        return $this->belongsTo('App\Bank', 'bankId','bankId');
    } 
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'accountId')->orderBy('transactionDate','ASC');
    }
    public function accountBalance()
    {
        return $this->hasMany('App\AccountBalance', 'accountId')->where('year',date('Y'));
    }
    //--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($id)
    {
        return $this->where('accountId', '=', $id)
                    ->get();
    }
//------------------------------------------
       public function getAllByBankAndOffice($bankId,$companyId)
    {
        return $this->where('bankId' , '=' , $bankId)
          ->where('companyId' , '=' , $companyId)
          ->orderBy('bankId', 'ASC')
          ->get();
    }

    public function getAllByOffice($companyId)
    {
        return $this->where('companyId','=',$companyId)
                    ->get();
    }
// //------------------------------------------
//     public function insertB($bankName, $countryId)
//     {

//         $bank              = new Bank;
//         $bank->bankName    = $bankName;
//         $bank->countryId   = $countryId;
//         $bank->bankAccount = '00000000000000000000';
//         $bank->initialBalance = '0.00';
//         $bank->balance01      = '0.00';
//         $bank->balance02      = '0.00';
//         $bank->balance03      = '0.00';
//         $bank->balance04      = '0.00';
//         $bank->balance05      = '0.00';
//         $bank->balance06      = '0.00';
//         $bank->balance07      = '0.00';
//         $bank->balance08      = '0.00';
//         $bank->balance09      = '0.00';
//         $bank->balance10      = '0.00';
//         $bank->balance11      = '0.00';
//         $bank->balance12      = '0.00';
//         $bank->save();
//     }
// //------------------------------------------
//     public function updateB($bankId, $bankName, $initialBalance, $balance01, $balance02, $balance03, $balance04, $balance05,
//         $balance06, $balance07, $balance08, $balance09, $balance10, $balance11, $balance12) {


//         $bank                = Bank::find($bankId);
//         $bank->bankName      = $bankName;
//         $bank->initialBalance  = $initialBalance;
//         $bank->balance01      = $balance01;
//         $bank->balance02      = $balance02;
//         $bank->balance03      = $balance03;
//         $bank->balance04      = $balance04;
//         $bank->balance05      = $balance05;
//         $bank->balance06      = $balance06;
//         $bank->balance07      = $balance07;
//         $bank->balance08      = $balance08;
//         $bank->balance09      = $balance09;
//         $bank->balance10      = $balance10;
//         $bank->balance11      = $balance11;
//         $bank->balance12      = $balance12;
//         $bank->save();


//     }
// //------------------------------------------
//    static public function updateBalanceForBank($sign, $bankId, $month, $amount)
//     {
//         $balanceMonth = 'balance'.$month;

//         if ($sign == '+') {
//               $bank = Bank::find($bankId);
//               $bank->$balanceMonth = $bank->$balanceMonth + $amount;
//               $bank->save();
//             } else {
//               $bank = Bank::find($bankId);
//                 if ($bank->$balanceMonth < $amount) {
//                     throw new \Exception('Error: Fondos Insuficientes en Banco');
//                 } else {
//                     $bank->$balanceMonth = $bank->$balanceMonth - $amount;
//                     $bank->save();
//                 }
//             }
//     }
// //------------------------------------------
//     public function deleteB($bankId)
//     {
//         return $this->where('bankId', '=', $bankId)->delete();
//     }
// //------------------------------------------
}
