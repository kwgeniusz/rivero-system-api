<?php

namespace App;

use App\Contract;
use App\ContactType;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'client';
    protected $primaryKey = 'clientId';

    protected $fillable = ['clientId', 'countryId', 'userId', 'clientCode', 'clientName',
        'clientAddress', 'clientPhone', 'clientEmail', 'created_at', 'lastUserId'];

    protected $dates = ['deleted_at'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function otherContact()
    {
        return $this->hasMany('App\ClientOtherContact', 'clientId', 'clientId');
    }
    public function contract()
    {
        return $this->hasMany('App\Contract', 'clientId', 'clientId');
    }
    public function invoice()
    {
        return $this->hasMany('App\Invoice', 'clientId', 'clientId');
    }
    public function proposal()
    {
        return $this->hasMany('App\Proposal', 'clientId', 'clientId');
    }
    public function country()
    {
        return $this->belongsTo('App\Country', 'countryId', 'countryId');
    }
    public function company()
    {
        return $this->hasOne('App\Company', 'companyId', 'companyId');
    }
       public function contactType()
    {
        return $this->hasOne('App\ContactType', 'contactTypeId', 'contactTypeId')->withTrashed();
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
   public function setClientNameAttribute($clientName)
   {
    $clientName = strtolower($clientName);
    $clientName = ucwords($clientName);

     return $this->attributes['clientName'] = ucwords($clientName);
   }
   public function setCompanyNameAttribute($companyName)
   {
    $companyName = strtolower($companyName);
    $companyName = ucwords($companyName);

     return $this->attributes['companyName'] = ucwords($companyName);
   } 
   public function setClientAddressAttribute($clientAddress)
   {
    $clientAddress = strtolower($clientAddress);
    $clientAddress = ucwords($clientAddress);

     return $this->attributes['clientAddress'] = ucwords($clientAddress);
   } 
//--------------------------------------------------------------------
    /** Query Scope  */
//--------------------------------------------------------------------
    // nombre codigo direccion
    public function scopeFilter($query, $filteredOut)
    {
        if ($filteredOut) {
            return $query->where('clientCode', 'LIKE', "%$filteredOut%")
                         ->orWhere('clientName', 'LIKE', "%$filteredOut%")
                         ->orWhere('businessPhone', 'LIKE', "%$filteredOut%")
                         ->orWhere('mainEmail', 'LIKE', "%$filteredOut%")
                         ->orWhereHas('company', function ($query) use ($filteredOut) {
                              return $query->where('companyName', 'LIKE', "%$filteredOut%");
                          });
        }
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
//       function getClientByGroupAndPagination($countryId,$companyId,$parentCompanyId,$filteredOut) {
//      //  Cuando parentCompanyId es mayor que cero  
//      if ($parentCompanyId > 0 ) {
//         $rs = $this->with('contactType','company','otherContact')
//                    ->where( function($query) use($countryId,$companyId,$parentCompanyId)  {
//                        $query->where('countryId', '=', $countryId)           
//                              ->where('parentCompanyId', '>', 0)
//                              ->where('parentCompanyId', '=', $parentCompanyId); 
//                      })->orWhere( function($query) use($countryId,$companyId,$parentCompanyId)  {
//                        $query->where('countryId', '=', $countryId)           
//                              ->where('parentCompanyId', '=', 0)
//                              ->where('companyId', '=', $parentCompanyId); 
//                      })->filter($filteredOut)
//                      ->orderBy('cltId', 'ASC')
//                      ->paginate(100); 
//      } else {
//      //  Cuando parentCompanyId es igual a cero 
//          $rs = $this->with('contactType','company','otherContact')
//                     ->where( function($query) use($countryId,$companyId,$parentCompanyId)  {
//                        $query->where('countryId', '=', $countryId)            
//                              ->where('parentCompanyId', '>', 0)
//                              ->where('parentCompanyId', '=', $companyId); 
//                      })->orWhere( function($query) use($countryId,$companyId,$parentCompanyId)  {
//                        $query->where('countryId', '=', $countryId)           
//                              ->where('parentCompanyId', '=', 0)
//                              ->where('companyId', '=', $companyId); 
//                      })->filter($filteredOut)
//                      ->orderBy('cltId', 'ASC')
//                      ->paginate(100); 
//      }      
//      return $rs;
//   }  
    function getClientByGroup($countryId,$companyId,$parentCompanyId,$filteredOut) {         
     //  Cuando parentCompanyId es mayor que cero  (COMPANIA HIJA)
     if ($parentCompanyId > 0 ) {
        $rs = $this->with('contactType','company','otherContact')
                   ->where( function($query) use($countryId,$companyId,$parentCompanyId)  {
                       $query->where('countryId', '=', $countryId)           
                             ->where('parentCompanyId', '>', 0)
                             ->where('parentCompanyId', '=', $parentCompanyId); 
                     })->orWhere( function($query) use($countryId,$companyId,$parentCompanyId)  {
                       $query->where('countryId', '=', $countryId)           
                             ->where('parentCompanyId', '=', 0)
                             ->where('companyId', '=', $parentCompanyId); 
                     })->filter($filteredOut)
                     ->get(); 
     } else {
     //  Cuando parentCompanyId es igual a cero (CORPORACION)
         $rs = $this->with('contactType','company','otherContact')
                    ->where( function($query) use($countryId,$companyId,$parentCompanyId)  {
                       $query->where('countryId', '=', $countryId)            
                             ->where('parentCompanyId', '>', 0)
                             ->where('parentCompanyId', '=', $companyId); 
                     })->orWhere( function($query) use($countryId,$companyId,$parentCompanyId)  {
                       $query->where('countryId', '=', $countryId)           
                             ->where('parentCompanyId', '=', 0)
                             ->where('companyId', '=', $companyId); 
                     })->filter($filteredOut)
                       ->get(); 
     }      
     return $rs;
  }
//------------------------------------------
    public function findById($id)
    {
        return $this->with('contract','invoice','proposal')
                    ->where('clientId', '=', $id)
                    ->get();
    }


    public function getClientByCompany($companyId) {  
               
         return $this->with('contactType','company','otherContact')
                    ->where('companyId', '=', $companyId)
                    ->orderBy('cltId', 'DESC')
                    ->get(); 
     }      
  
//------------------------------------------
//     public function findNameByOffice($companyId)

//     {
//         $result = DB::select("SELECT DISTINCT client.clientName FROM contract
//                               INNER JOIN client ON contract.clientId = client.clientId
//                               WHERE companyId = $companyId ");

//         return $result;
//     }
// //------------------------------------------
//     public function findPhoneByOffice($companyId)
//     {
//         $result = DB::select("SELECT DISTINCT client.clientPhone FROM contract
//                               INNER JOIN client ON contract.clientId = client.clientId
//                               WHERE companyId = $companyId ");

//         return $result;
//     }
//------------------------------------------
    public function insertClient($countryId, $companyId, $parentCompanyId, $data)
    {

          $error = null;

     DB::beginTransaction();
      try {
          //bloquear multiple 
      $oConfiguration     = new CompanyConfiguration();
      $clientNumber       = $oConfiguration->retrieveClientNumber($companyId,$parentCompanyId);
      $clientNumberFormat = $oConfiguration->generateClientNumberFormat($companyId,$parentCompanyId);
                            $oConfiguration->increaseClientNumber($companyId,$parentCompanyId);

        $client                = new Client;
        $client->countryId     = $countryId;
        $client->companyId     = $companyId;
        $client->parentCompanyId= $parentCompanyId;
        $client->cltId         = $clientNumber;
        $client->clientCode    = $clientNumberFormat;
        $client->clientType    = $data['clientType'];
        $client->companyName   = $data['companyName'];
        $client->clientName    = $data['clientName'];
        $client->gender        = $data['gender'];
        $client->clientAddress = $data['clientAddress'];
        $client->businessPhone = $data['businessPhone'];
        $client->homePhone   = $data['homePhone'];
        $client->otherPhone   = $data['otherPhone'];
        $client->fax          = $data['fax'];
        $client->mainEmail   = $data['mainEmail'];
        $client->secondaryEmail   = $data['secondaryEmail'];
        $client->contactTypeId   = $data['contactTypeId'];
        $client->created_at   = date('Y-m-d H:i:s');
        $client->lastUserId    = Auth::user()->userId;
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
    public function updateClient($companyId,$clientId ,$data)
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
    public function deleteClient($companyId,$clientId)
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
