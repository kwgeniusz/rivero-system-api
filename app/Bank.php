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
        'countryId',
        'bankName',
    ];
//--------------------------------------------------------------------
/** Relations */
//-------------------------------------------------------------------
  public function account()
    {
        return $this->hasMany('App\Account','bankId','bankId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
  public function findById($id,$countryId)
    {
        return $this->with('account')
                    ->where('bankId', '=', $id)
                    ->where('countryId', $countryId)
                    ->get();
    }
//------------------------------------------
 // public function getAllByCountry($countryId)
 //    {
 //        return $this->with('account')
 //          ->where('countryId' , '=' , $countryId)
 //          ->orderBy('bankId', 'ASC')
 //          ->get();
 //    }

 public function getAllByOffice($companyId)
    {
        return $this->select('bank.bankId','bankName')
                     ->join('account', 'account.bankId', '=', 'bank.bankId')
                    ->where('companyId','=',$companyId)
                    ->distinct('bankName')
                    ->get();
    }
}
