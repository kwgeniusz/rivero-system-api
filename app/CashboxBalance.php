<?php

namespace App;


use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class CashboxBalance extends Model
{
    public $timestamps = false;

    protected $table      = 'cashbox_balance';
    protected $primaryKey = 'cashboxBalanceId';
    protected $fillable   = [
        'cashboxId',
        'year',
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

}
