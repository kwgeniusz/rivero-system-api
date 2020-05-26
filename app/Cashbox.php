<?php

namespace App;


use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class Cashbox extends Model
{
    public $timestamps = false;

    protected $table      = 'cashbox';
    protected $primaryKey = 'cashboxId';
    protected $fillable   = [
        'countryId',
        'officeId'
    ];
//--------------------------------------------------------------------
 /** Relations */
//--------------------------------------------------------------------
    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'cashboxId')->orderBy('transactionDate','ASC');
    }
    public function cashboxBalance()
    {
        return $this->hasMany('App\CashboxBalance', 'cashboxId')->where('year',date('Y'));
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------

    public function findById($id,$officeId)
    {
        return $this->where('cashboxId', '=', $id)
                    ->where('officeId', $officeId)
                    ->get();
    }
//------------------------------------
       public function getAllByOffice($officeId)
    {
        return $this->where('officeId' , '=' , $officeId)
          ->orderBy('cashboxId', 'ASC')
          ->get();
    }

}
