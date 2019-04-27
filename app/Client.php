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

    protected $fillable = ['userId', 'clientId','clientCode','clientName',
         'clientAddress', 'clientPhone', 'clientEmail','dateCreated', 'lastUserId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->hasMany('App\Contract', 'clientId', 'clientId');
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
    public function insertClient($clientName, $clientAddress, $clientPhone, $clientEmail)
    {

        $client                    = new Client;
        $client->userId            = 1;
        $client->clientName        = $clientName;
        $client->clientAddress     = $clientAddress;
        $client->clientPhone       = $clientPhone;
        $client->clientEmail       = $clientEmail;
        $client->dateCreated       = date('Y-m-d H:i:s');
        $client->lastUserId        = Auth::user()->userId;
        $client->save();
    }
//------------------------------------------
    public function updateClient($clientId, $clientName, $clientAddress, $clientPhone, $clientEmail)
    {
        $this->where('clientId', $clientId)->update(array(
            'clientName'        => $clientName,
            'clientAddress'     => $clientAddress,
            'clientPhone'       => $clientPhone,
            'clientEmail'       => $clientEmail,
        ));
    }
//------------------------------------------
    public function deleteClient($clientId)
    {
        return $this->where('clientId', '=', $clientId)->delete();
    }
//------------------------------------------
}
