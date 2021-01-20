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
        'companyId'
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

    public function findById($id,$companyId)
    {
        return $this->where('cashboxId', '=', $id)
                    ->where('companyId', $companyId)
                    ->get();
    }
//------------------------------------
       public function getAllByOffice($companyId)
    {
        return $this->with('transaction.user')
          ->where('companyId' , '=' , $companyId)
          ->orderBy('cashboxId', 'ASC')
          ->get();
    }

}
