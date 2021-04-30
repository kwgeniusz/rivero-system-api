<?php

namespace App;

// use App\Contract;
// use App\ContactType;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralLedger extends Model
{
   //traits
    //   use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'acc_general_ledger';
    protected $primaryKey = 'generalLedgerId';

    protected $fillable = ['generalLedgerId','countryId' ,'companyId','accountCode','accountName','leftMargin','parentAccountCode','accountClassificationCode', 'accountTypeCode','debit','credit'];
    // protected $dates = ['deleted_at'];


//--------------------------------------------------------------------
    /** RELATIONS **/
//--------------------------------------------------------------------
    public function accountType()
    {
        return $this->hasOne('App\AccountType', 'accountTypeCode', 'accountTypeCode');
    }
    public function accountClassification()
    {
        return $this->hasOne('App\AccountClassification', 'accountClassificationCode', 'accountClassificationCode');
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
    public function findById($id,$companyId)
    {
        return $this->with('contract','invoice','proposal')
                    ->where('clientId', '=', $id)
                    // ->where('companyId','=', $companyId)
                    ->get();
    }

    public function getAllByCompany($companyId) 
    {  
         return $this->with('accountType','accountClassification')
                     ->where('companyId', '=', $companyId)
                     ->orderBy('accountCode', 'DESC')
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
        $generalLedger->accountClassification   = $data['accountClassification'];
        $generalLedger->accountTypeCode         = $data['accountTypeCode'];
        $generalLedger->debit                   = $data['debit'];
        $generalLedger->credit                  = $data['credit'];
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
    public function updateG($companyId,$clientId ,$data)
    {
          $error = null;

     DB::beginTransaction();
      try {

        $client                     = Client::find($clientId);
        $client->clientType    = $data['clientType'];
        $client->companyName   = $data['companyName'];
        $client->clientName    = $data['clientName'];
        $client->gender        = $data['gender'];
        $client->clientAddress = $data['clientAddress'];
        $client->businessPhone = $data['businessPhone'];
        $client->homePhone     = $data['homePhone'];
        $client->otherPhone    = $data['otherPhone'];
        $client->fax           = $data['fax'];
        $client->mainEmail     = $data['mainEmail'];
        $client->secondaryEmail   = $data['secondaryEmail'];
        $client->contactTypeId   = $data['contactTypeId'];
        $client->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Cliente Modificado "];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteG($companyId,$clientId)
    {
        try {
          $this->where('companyId', '=', $companyId)
               ->where('clientId', '=', $clientId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Cliente Eliminado'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

    
}
