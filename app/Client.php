<?php

namespace App;

use App\Contract;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public $timestamps = false;

    protected $table      = 'client';
    protected $primaryKey = 'clientId';

    protected $fillable = ['clientId', 'countryId', 'userId', 'clientCode', 'clientName',
        'clientAddress', 'clientPhone', 'clientEmail', 'dateCreated', 'lastUserId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'clientId', 'clientId');
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'countryId', 'countryId');
    }

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('clientId', 'ASC')->get();
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('clientId', '=', $id)->get();
    }
//------------------------------------------
    public function findNameByOffice($officeId)
    {
        $result = DB::select("SELECT DISTINCT client.clientName FROM contract
                              INNER JOIN client ON contract.clientId = client.clientId
                              WHERE officeId = $officeId ");

        return $result;
    }
//------------------------------------------
    public function findPhoneByOffice($officeId)
    {
        $result = DB::select("SELECT DISTINCT client.clientPhone FROM contract
                              INNER JOIN client ON contract.clientId = client.clientId
                              WHERE officeId = $officeId ");

        return $result;
    }
//------------------------------------------
    public function insertClient($countryId, $clientName, $clientAddress, $clientPhone, $clientEmail)
    {

      $oConfiguration = new Configuration();
      $clientNumber = $oConfiguration->retrieveClientNumber($countryId);
      $clientNumber++;
      $oConfiguration->updateClientNumber($countryId, $clientNumber);

        // make contract number format
        $stringLength = 5;
        $strPad       = "0";

        if ($clientNumber < 1) {
            $clientNumber = "";
        }

        $country = Country::where('countryId', $countryId)->get();
        $format1 = $country[0]->abbreviation."-";
        $format2 = "CU-";
        $format3 = str_pad($clientNumber, $stringLength, $strPad, STR_PAD_LEFT);
        // numero de contrato en foramto
        $clientNumberFormat = $format1 . $format2 . $format3 ;

        $client                = new Client;
        $client->userId        = 1;
        $client->countryId     = $countryId;
        $client->clientCode    = $clientNumberFormat;
        $client->clientName    = $clientName;
        $client->clientAddress = $clientAddress;
        $client->clientPhone   = $clientPhone;
        $client->clientEmail   = $clientEmail;
        $client->dateCreated   = date('Y-m-d H:i:s');
        $client->lastUserId    = Auth::user()->userId;
        $client->save();
    }
//------------------------------------------
    public function updateClient($clientId, $countryId, $clientName, $clientAddress, $clientPhone, $clientEmail)
    {
        $this->where('clientId', $clientId)->update(array(
            'countryId'     => $countryId,
            'clientName'    => $clientName,
            'clientAddress' => $clientAddress,
            'clientPhone'   => $clientPhone,
            'clientEmail'   => $clientEmail,
        ));
    }
//------------------------------------------
    public function deleteClient($clientId)
    {
        
        try {
          $this->where('clientId', '=', $clientId)->delete();
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
