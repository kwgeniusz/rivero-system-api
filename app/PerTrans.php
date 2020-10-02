<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerTrans extends Model
{
   //traits
    //   use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'hrpermanent_transaction';
    protected $primaryKey = 'hrpermanentTransactionId';
    // protected $dates = ['deleted_at'];

    protected $fillable = ['countryId', 'companyId', 'staffCode', 'transactionTypeCode', 'quantity', 'amount', 'balance','initialBalance'];

    function getPeTransaction(){
        // $company = session('countryId');
        // $country = session('companyId');
        return DB::table('hrpermanent_transaction')
        ->join('hrstaff', 'hrpermanent_transaction.staffCode', '=', 'hrstaff.staffCode')
        ->join('country', 'hrpermanent_transaction.countryId', '=', 'country.countryId')
        ->join('company', 'hrpermanent_transaction.companyId', '=', 'company.companyId')
        ->join('hrtransaction_type', function ($join){
            $join->on('hrpermanent_transaction.transactionTypeCode', '=', 'hrtransaction_type.transactionTypeCode')
                 ->where('hrtransaction_type.companyId', '=', session('companyId'))
                 ->where('hrtransaction_type.countryId', '=', session('countryId'));
        })
        ->select('hrpermanent_transaction.*', 'hrstaff.shortName','company.companyShortName','country.countryName','hrtransaction_type.transactionTypeName')
        ->whereNull('hrpermanent_transaction.deleted_at')
        ->where('hrpermanent_transaction.companyId', '=', session('companyId'))
        ->where('hrpermanent_transaction.countryId', '=', session('countryId'))
        ->orderBy('hrstaff.staffCode', 'asc')
        ->get();
        
    }

}