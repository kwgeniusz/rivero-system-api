<?php

namespace App;


use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public $timestamps = false;

    protected $table      = 'bank';
    protected $primaryKey = 'bankId';
    protected $fillable   = [
        'bankId',
        'bankName',
        'initialBalance',
        'balance01',
        'balance02',
        'balance03',
        'balance04',
        'balance05',
        'balance06',
        'balance07',
        'balance08',
        'balance09',
        'balance10',
        'balance11',
        'balance12',
    ];
    //--------------------------------------------------------------------
    /** Relations */
    //--------------------------------------------------------------------
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'transactionId');
    }
    //--------------------------------------------------------------------

    //------------------------ACCESORES--------------//
    public function getInitialBalanceAttribute($initialBalance)
    {
        return decrypt($initialBalance);
    }
        public function getBalance01Attribute($balance01)
    {
        return decrypt($balance01);
    }
        public function getBalance02Attribute($balance02)
    {
        return decrypt($balance02);
    }
        public function getBalance03Attribute($balance03)
    {
        return decrypt($balance03);
    }
        public function getBalance04Attribute($balance04)
    {
        return decrypt($balance04);
    }
        public function getBalance05Attribute($balance05)
    {
        return decrypt($balance05);
    }
        public function getBalance06Attribute($balance06)
    {
        return decrypt($balance06);
    }
        public function getBalance07Attribute($balance07)
    {
        return decrypt($balance07);
    }
        public function getBalance08Attribute($balance08)
    {
        return decrypt($balance08);
    }
        public function getBalance09Attribute($balance09)
    {
        return decrypt($balance09);
    }
        public function getBalance10Attribute($balance10)
    {
        return decrypt($balance10);
    }
        public function getBalance11Attribute($balance11)
    {
        return decrypt($balance11);
    }
        public function getBalance12Attribute($balance12)
    {
        return decrypt($balance12);
    }
    //------------------------MUTADORES--------------------------------
        public function setInitialBalanceAttribute($initialBalance)
    {
        return $this->attributes['initialBalance'] = encrypt($initialBalance);
    }
        public function setBalance01Attribute($balance01)
    {
        return $this->attributes['balance01'] = encrypt($balance01);
    }
        public function setBalance02Attribute($balance02)
    {
        return $this->attributes['balance02'] = encrypt($balance02);
    }
        public function setBalance03Attribute($balance03)
    {
        return $this->attributes['balance03'] = encrypt($balance03);
    }
        public function setBalance04Attribute($balance04)
    {
        return $this->attributes['balance04'] = encrypt($balance04);
    }
        public function setBalance05Attribute($balance05)
    {
        return $this->attributes['balance05'] = encrypt($balance05);
    }
        public function setBalance06Attribute($balance06)
    {
        return $this->attributes['balance06'] = encrypt($balance06);
    }
        public function setBalance07Attribute($balance07)
    {
        return $this->attributes['balance07'] = encrypt($balance07);
    }
        public function setBalance08Attribute($balance08)
    {
        return $this->attributes['balance08'] = encrypt($balance08);
    }
        public function setBalance09Attribute($balance09)
    {
        return $this->attributes['balance09'] = encrypt($balance09);
    }
        public function setBalance10Attribute($balance10)
    {
        return $this->attributes['balance10'] = encrypt($balance10);
    }
        public function setBalance11Attribute($balance11)
    {
        return $this->attributes['balance11'] = encrypt($balance11);
    }
         public function setBalance12Attribute($balance12)
    {
        return $this->attributes['balance12'] = encrypt($balance12);
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

    public function findById($id,$officeId)
    {
        return $this->where('bankId', '=', $id)
                    ->where('officeId', $officeId)
                    ->get();
    }
//------------------------------------------
    
    // public function getAll()
    // {
    //     return $this->orderBy('bankId', 'ASC')
    //                 ->get();
    // }
//------------------------------------------
       public function getAllByOffice($officeId)
    {
        return $this->where('officeId' , '=' , $officeId)
          ->orderBy('bankId', 'ASC')
          ->get();
    }
//------------------------------------------
    public function insertB($bankName, $countryId)
    {

        $bank              = new Bank;
        $bank->bankName    = $bankName;
        $bank->countryId   = $countryId;
        $bank->bankAccount = '00000000000000000000';
        $bank->initialBalance = '0.00';
        $bank->balance01      = '0.00';
        $bank->balance02      = '0.00';
        $bank->balance03      = '0.00';
        $bank->balance04      = '0.00';
        $bank->balance05      = '0.00';
        $bank->balance06      = '0.00';
        $bank->balance07      = '0.00';
        $bank->balance08      = '0.00';
        $bank->balance09      = '0.00';
        $bank->balance10      = '0.00';
        $bank->balance11      = '0.00';
        $bank->balance12      = '0.00';
        $bank->save();
    }
//------------------------------------------
    public function updateB($bankId, $bankName, $initialBalance, $balance01, $balance02, $balance03, $balance04, $balance05,
        $balance06, $balance07, $balance08, $balance09, $balance10, $balance11, $balance12) {


        $bank                = Bank::find($bankId);
        $bank->bankName      = $bankName;
        $bank->initialBalance  = $initialBalance;
        $bank->balance01      = $balance01;
        $bank->balance02      = $balance02;
        $bank->balance03      = $balance03;
        $bank->balance04      = $balance04;
        $bank->balance05      = $balance05;
        $bank->balance06      = $balance06;
        $bank->balance07      = $balance07;
        $bank->balance08      = $balance08;
        $bank->balance09      = $balance09;
        $bank->balance10      = $balance10;
        $bank->balance11      = $balance11;
        $bank->balance12      = $balance12;
        $bank->save();


    }
//------------------------------------------
   static public function updateBalanceForBank($sign, $bankId, $month, $amount)
    {
        $balanceMonth = 'balance'.$month;

        if ($sign == '+') {
              $bank = Bank::find($bankId);
              $bank->$balanceMonth = $bank->$balanceMonth + $amount;
              $bank->save();
            } else {
              $bank = Bank::find($bankId);
                if ($bank->$balanceMonth < $amount) {
                    throw new \Exception('Error: Fondos Insuficientes en Banco');
                } else {
                    $bank->$balanceMonth = $bank->$balanceMonth - $amount;
                    $bank->save();
                }
            }
    }
//------------------------------------------
    public function deleteB($bankId)
    {
        return $this->where('bankId', '=', $bankId)->delete();
    }
//------------------------------------------
}
