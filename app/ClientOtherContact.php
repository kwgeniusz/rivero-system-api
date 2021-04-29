<?php

namespace App;

use App\Contract;
use App\ContactType;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientOtherContact extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'client_other_contact';
    protected $primaryKey = 'otherContactId';

    protected $fillable = ['otherContactId', 'name', 'relationship', 'mainPhone', 'secondaryPhone',
        'mainEmail', 'secondaryEmail'];
        
    protected $dates = ['deleted_at'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->belongsTo('App\Client', 'clientId', 'clientId');
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
   public function setNameAttribute($name)
   {
    $name = strtolower($name);
    $name = ucwords($name);

     return $this->attributes['name'] = ucwords($name);
   }
   public function setRelationshipAttribute($relationship)
   {
    $relationship = strtolower($relationship);
    $relationship = ucwords($relationship);

     return $this->attributes['relationship'] = ucwords($relationship);
   } 
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($id)
    {
        return $this->where('otherContactId', '=', $id)
                    ->get();
    }
//------------------------------------------
    public function insertC($clientId,$data)
    {
          $error = null;
     DB::beginTransaction();
      try {

        $client                 = new ClientOtherContact;
        $client->clientId       = $clientId;
        $client->name           = $data['name'];
        $client->relationship   = $data['relationship'];
        $client->mainPhone      = $data['mainPhone'];
        $client->secondaryPhone = $data['secondaryPhone'];
        $client->mainEmail      = $data['mainEmail'];
        $client->secondaryEmail = $data['secondaryEmail'];
        $client->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Otro Contacto creado exitosamente ",'model'=>$client];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }

    }
//------------------------------------------
    public function updateC($otherContactId ,$data)
    {
          $error = null;

     DB::beginTransaction();
      try {

        $client                     = ClientOtherContact::find($otherContactId);
        $client->name           = $data['name'];
        $client->relationship   = $data['relationship'];
        $client->mainPhone      = $data['mainPhone'];
        $client->secondaryPhone = $data['secondaryPhone'];
        $client->mainEmail      = $data['mainEmail'];
        $client->secondaryEmail = $data['secondaryEmail'];
        $client->save();
            
        $client->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'message' => "Contacto Modificado "];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
    public function deleteC($otherContactId)
    {
        
        try {
          $this->where('otherContactId', '=', $otherContactId)
               ->delete();
               
            $success = true;
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
        }

        if ($success) {
            return $rs = ['alert' => 'info', 'message' => 'Contacto Eliminado'];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
//------------------------------------------

    
}
