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
        'clientAddress', 'clientPhone', 'clientEmail', 'dateCreated', 'lastUserId'];
    protected $dates = ['deleted_at'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
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
       public function contactType()
    {
        return $this->hasOne('App\ContactType', 'contactTypeId', 'contactTypeId');
    }
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Query Scope  */
//--------------------------------------------------------------------
    //nombre codigo direccion
    public function scopeFilter($query, $filteredOut)
    {
        if ($filteredOut) {
            return $query->where('clientCode', 'LIKE', "%$filteredOut%")
                         ->orWhere('clientName', 'LIKE', "%$filteredOut%")
                         ->orWhere('clientPhone', 'LIKE', "%$filteredOut%")
                         ->orWhere('clientEmail', 'LIKE', "%$filteredOut%")
                         ->orWhereHas('contactType', function ($query) use ($filteredOut) {
                              return $query->where('contactTypeName', 'LIKE', "%$filteredOut%");
                          });
        }
    }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll($countryId)
    {
        return $this->orderBy('clientId', 'ASC')
                    ->where('countryId','=', $countryId)
                    ->get();
    }
//------------------------------------------
    public function findById($id,$countryId)
    {
        return $this->with('contract','invoice','proposal')
                    ->where('clientId', '=', $id)
                    ->where('countryId','=', $countryId)
                    ->get();
    }
//------------------------------------------
    public function findNameByOffice($companyId)
    {
        $result = DB::select("SELECT DISTINCT client.clientName FROM contract
                              INNER JOIN client ON contract.clientId = client.clientId
                              WHERE companyId = $companyId ");

        return $result;
    }
//------------------------------------------
    public function findPhoneByOffice($companyId)
    {
        $result = DB::select("SELECT DISTINCT client.clientPhone FROM contract
                              INNER JOIN client ON contract.clientId = client.clientId
                              WHERE companyId = $companyId ");

        return $result;
    }
//------------------------------------------
    public function insertClient($countryId, $clientName, $clientAddress, $contactTypeId,$clientPhone, $clientEmail)
    {
// bloquear multiple 
      $oConfiguration     = new CountryConfiguration();
      
      $clientNumber       = $oConfiguration->retrieveClientNumber($countryId);
      $clientNumber++;
      $clientNumberFormat = $oConfiguration->generateClientNumberFormat($countryId);
                            $oConfiguration->increaseClientNumber($countryId);

        $client                = new Client;
        $client->cltId         = $clientNumber;
        $client->userId        = 1;
        $client->countryId     = $countryId;
        $client->clientCode    = $clientNumberFormat;
        $client->clientName    = $clientName;
        $client->clientAddress = $clientAddress;
        $client->contactTypeId = $contactTypeId;
        $client->clientPhone   = $clientPhone;
        $client->clientEmail   = $clientEmail;
        $client->dateCreated   = date('Y-m-d H:i:s');
        $client->lastUserId    = Auth::user()->userId;
        $client->save();

        return $client;
    }
//------------------------------------------
    public function updateClient($clientId, $countryId, $clientName, $clientAddress,$contactTypeId, $clientPhone, $clientEmail)
    {
        $this->where('clientId', $clientId)->update(array(
            'countryId'     => $countryId,
            'clientName'    => $clientName,
            'clientAddress' => $clientAddress,
            'contactTypeId' => $contactTypeId,
            'clientPhone'   => $clientPhone,
            'clientEmail'   => $clientEmail,
        ));
    }
//------------------------------------------
    public function deleteClient($clientId,$countryId)
    {
        
        try {
          $this->where('clientId', '=', $clientId)
               ->where('countryId', '=', $countryId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Cliente Eliminado'];
        } else {
            return $result = ['alert' => 'error', 'msj' => 'No se Puede Eliminar porque este registro tiene relacion con otros datos.'];
        }
    }
//------------------------------------------
}
