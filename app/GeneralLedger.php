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
    // public function otherContact()
    // {
    //     return $this->hasMany('App\ClientOtherContact', 'clientId', 'clientId');
    // }
    // public function contract()
    // {
    //     return $this->hasMany('App\Contract', 'clientId', 'clientId');
    // }
    // public function invoice()
    // {
    //     return $this->hasMany('App\Invoice', 'clientId', 'clientId');
    // }
    // public function proposal()
    // {
    //     return $this->hasMany('App\Proposal', 'clientId', 'clientId');
    // }
    // public function country()
    // {
    //     return $this->belongsTo('App\Country', 'countryId', 'countryId');
    // }
    // public function company()
    // {
    //     return $this->hasOne('App\Company', 'companyId', 'companyId');
    // }
    //    public function contactType()
    // {
    //     return $this->hasOne('App\ContactType', 'contactTypeId', 'contactTypeId')->withTrashed();
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
//    public function setCompanyNameAttribute($companyName)
//    {
//     $companyName = strtolower($companyName);
//     $companyName = ucwords($companyName);

//      return $this->attributes['companyName'] = ucwords($companyName);
//    } 
//    public function setClientAddressAttribute($clientAddress)
//    {
//     $clientAddress = strtolower($clientAddress);
//     $clientAddress = ucwords($clientAddress);

//      return $this->attributes['clientAddress'] = ucwords($clientAddress);
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
         return $this->where('companyId', '=', $companyId)
                     ->orderBy('generalLedgerId', 'DESC')
                     ->get(); 
     }      
    public function insertG($countryId, $companyId, $parentCompanyId, $data)
    {

          $error = null;

     DB::beginTransaction();
      try {
          //bloquear multiple 
      $oConfiguration     = new CompanyConfiguration();
      $clientNumber       = $oConfiguration->retrieveClientNumber($companyId,$parentCompanyId);
      $clientNumberFormat = $oConfiguration->generateClientNumberFormat($companyId,$parentCompanyId);
                            $oConfiguration->increaseClientNumber($companyId,$parentCompanyId);

        $client                     = new Client;
        $client->countryId          = $countryId;
        $client->companyId          = $companyId;
        $client->parentCompanyId    = $parentCompanyId;
        $client->cltId              = $clientNumber;
        $client->clientCode         = $clientNumberFormat;
        $client->clientType         = $data['clientType'];
        $client->companyName        = $data['companyName'];
        $client->clientName         = $data['clientName'];
        $client->gender             = $data['gender'];
        $client->clientAddress      = $data['clientAddress'];
        $client->businessPhone      = $data['businessPhone'];
        $client->homePhone          = $data['homePhone'];
        $client->otherPhone         = $data['otherPhone'];
        $client->fax                = $data['fax'];
        $client->mainEmail          = $data['mainEmail'];
        $client->secondaryEmail     = $data['secondaryEmail'];
        $client->contactTypeId      = $data['contactTypeId'];
        $client->created_at         = date('Y-m-d H:i:s');
        $client->lastUserId         = Auth::user()->userId;
        $client->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Cliente N° $client->clientCode creado exitosamente ",'model'=>$client];
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
