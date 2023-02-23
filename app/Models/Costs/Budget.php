<?php

namespace App\Models\Costs;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'cost_budget';
    protected $primaryKey = 'entityId';
	
    protected $fillable =  ['entityId','moduleName','entityName','entityKey']; 
    // protected $dates = ['deleted_at'];

//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    // public function accountType()
    // {
    //     return $this->hasOne(AccountType::class, 'accountTypeCode', 'accountTypeCode')->where('countryId', '=',session('countryId'));
    // }
    // public function accountClassification()
    // {
    //     return $this->hasOne(AccountClassification::class, 'accountClassificationCode', 'accountClassificationCode')->where('countryId', '=',session('countryId'));
    // }
    // public function daughterAccount()
    // {
    //     return $this->hasMany(GeneralLedger::class, 'parentAccountId', 'generalLedgerId');
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
    public function findById($id)
    {
        return $this->where('generalLedgerId', '=', $id)
                    ->get();
    }

    public function getAllByPrecontract($countryId, $companyId, $precontractId) 
    {  
         return $this->where('precontractId', $precontractId)
                     ->where('countryId', $countryId)
                     ->where('companyId', $companyId)
                     ->orderBy('budgetId', 'ASC')
                     ->get(); 
     }        

}//end of the class
