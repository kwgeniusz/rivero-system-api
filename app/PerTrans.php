<?php

namespace App;

use Illuminate\Support\Facades\DB;
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

    protected $fillable = ['countryId', 'companyId', 'staffCode', 'transactionTypeCode', 'quantity', 'amount', 'balance','initialBalance','cde'];

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
    
    function getEmployees($country, $company)
    {
        return DB::table('hrstaff')
            ->select('hrstaff.shortName','hrstaff.staffCode','hrstaff.countryId','hrstaff.companyId')
            ->where('hrstaff.countryId', '=', $country)
            ->where('hrstaff.companyId', '=', $company)
            ->where('hrstaff.status', '=', 'A')
            // ->where('hrstaff.companyId', '=',4)
            ->get();
    }
    function getHistoryLoans(  $staffCode )
    {
        return DB::table('hrpermanent_transaction')
            ->select('hrpermanent_transaction.*')
            ->where('hrpermanent_transaction.staffCode', '=', $staffCode)
            ->where('hrpermanent_transaction.transactionTypeCode', '=', 2004)
            ->whereNull('deleted_at')
            ->get();
    }

    function getBlockedTransaction($idCountry, $idCompany, $transactionCode, $staffCode)
    {
        return DB::table('hrpermanent_transaction')
        ->select('blocked')
        ->where('countryId', '=', $idCountry)
        ->where('companyId', '=', $idCompany)
        ->where('transactionTypeCode', '=', $transactionCode)
        ->where('staffCode', '=', $staffCode)
        ->where('blocked', '>', 0)
        ->whereNull('deleted_at')
        ->get();
    }
    function getChildrenCount($idCountry, $idCompany, $staffCode)
    {
        return DB::table('hrstaff')
        ->select('childrenCount')
        ->where('countryId', '=', $idCountry)
        ->where('companyId', '=', $idCompany)
        ->where('staffCode', '=', $staffCode)
        ->whereNull('deleted_at')
        ->get();
    }

}