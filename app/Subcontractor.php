<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcontractor extends Model
{
   //traits
      use SoftDeletes;
      
    public $timestamps = false;

    protected $table      = 'subcontractor';
    protected $primaryKey = 'subcontId';

    protected $fillable = ['subcontId', 'countryId', 'subcontName', 'subcontType', 'subcontDNI',
        'subcontAddress', 'subcontPhone', 'subcontEmail'];
    protected $dates = ['deleted_at'];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
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
    //    public function contactType()
    // {
    //     return $this->hasOne('App\ContactType', 'contactTypeId', 'contactTypeId');
    // }
//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Query Scope  */
//--------------------------------------------------------------------

//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByCountry($countryId)
    {
        return $this->orderBy('subcontId', 'ASC')
                    ->where('countryId','=', $countryId)
                    ->paginate(300);
    }

       public function getAllByCompany($companyId)
    {
        return $this->orderBy('subcontId', 'ASC')
                    ->where('companyId','=', $companyId)
                    ->paginate(300);
    } 
//------------------------------------------
    public function findById($id,$countryId)
    {
        return $this->where('subcontId', '=', $id)
                    ->where('countryId','=', $countryId)
                    ->get();
    }

// //------------------------------------------
    public function insertS($countryId,$companyId,$data)
    {

     $error = null;

     DB::beginTransaction();
      try {

        $subcontractor                      = new Subcontractor;
        $subcontractor->countryId           = $countryId;
        $subcontractor->companyId           = $companyId;
        $subcontractor->subcontType         = $data['subcontType'];
        $subcontractor->name                = $data['name'];
        $subcontractor->representative      = $data['representative'];
        $subcontractor->DNIType             = $data['DNIType'];
        $subcontractor->DNI                 = $data['DNI'];
        $subcontractor->mainPhone           = $data['mainPhone'];
        $subcontractor->address             = $data['address'];
        $subcontractor->email               = $data['email'];
        $subcontractor->bankName            = $data['bankName'];
        $subcontractor->headline            = $data['headline'];
        $subcontractor->accountNumber       = $data['accountNumber'];
        $subcontractor->routingNumber       = $data['routingNumber'];
        $subcontractor->wires               = $data['wires'];
        $subcontractor->zelle               = $data['zelle'];
        $subcontractor->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {

            $success = false;
            $error   = $e->getMessage();
            DB::rollback();
        }

        if ($success) {
          return $rs  = ['alert' => 'success', 'msj' => "Subcontractista: $subcontractor->name creado exitosamente ",'model'=>$subcontractor];
        } else {
            return $rs = ['alert' => 'error', 'msj' => $error];
        }
    }
// //------------------------------------------
//     public function updateClient($clientId, $countryId, $clientName, $clientAddress,$contactTypeId, $clientPhone, $clientEmail)
//     {
//         $this->where('clientId', $clientId)->update(array(
//             'countryId'     => $countryId,
//             'clientName'    => $clientName,
//             'clientAddress' => $clientAddress,
//             'contactTypeId' => $contactTypeId,
//             'clientPhone'   => $clientPhone,
//             'clientEmail'   => $clientEmail,
//         ));
//     }
// //------------------------------------------
//     public function deleteClient($clientId,$countryId)
//     {
        
//         try {
//           $this->where('clientId', '=', $clientId)
//                ->where('countryId', '=', $countryId)
//                ->delete();
               
//             $success = true;
//         } catch (\Exception $e) {
//             $error   = $e->getMessage();
//             $success = false;
//         }

//         if ($success) {
//             return $result = ['alert' => 'info', 'msj' => 'Cliente Eliminado'];
//         } else {
//             return $result = ['alert' => 'error', 'msj' => 'No se Puede Eliminar porque este registro tiene relacion con otros datos.'];
//         }
//     }
//------------------------------------------

 
}
