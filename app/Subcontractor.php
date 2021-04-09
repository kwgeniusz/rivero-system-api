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
                    ->get();
    }

       public function getAllByCompany($companyId)
    {
        return $this->orderBy('subcontId', 'ASC')
                    ->where('companyId','=', $companyId)
                    ->get();
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
        $subcontractor->companyName                = $data['companyName'];
        $subcontractor->subcontractorName      = $data['subcontractorName'];
        // $subcontractor->serviceOffered      = $data['serviceOffered'];
        $subcontractor->typeTaxId             = $data['typeTaxId'];
        $subcontractor->taxId                 = $data['taxId'];
        $subcontractor->address               = $data['address'];
        $subcontractor->mainPhone           = $data['mainPhone'];
        $subcontractor->secondaryPhone      = $data['secondaryPhone'];
        $subcontractor->mainEmail               = $data['mainEmail'];
        $subcontractor->secondaryEmail               = $data['secondaryEmail'];
        $subcontractor->typeForm1099        = $data['typeForm1099'];
        
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
          return $rs  = ['alert' => 'success', 'message' => "Subcontractista: $subcontractor->subcontractorName creado exitosamente ",'model'=>$subcontractor];
        } else {
            return $rs = ['alert' => 'error', 'message' => $error];
        }
    }
// //------------------------------------------
    public function updateS($subcontId, $data)
    {
        $error = null;

        DB::beginTransaction();
         try {

            dd($data);
            exit();
            // $msg = json_decode(file_get_contents("php://input"));
           $subcontractor                   = Subcontractor::find($subcontId);
        $subcontractor->subcontType         = $data['subcontType'];
        $subcontractor->companyName         = $data['companyName'];
        $subcontractor->subcontractorName   = $data['subcontractorName'];
        // $subcontractor->serviceOffered   = $data['serviceOffered'];
        $subcontractor->typeTaxId           = $data['typeTaxId'];
        $subcontractor->taxId               = $data['taxId'];
        $subcontractor->address             = $data['address'];
        $subcontractor->mainPhone           = $data['mainPhone'];
        $subcontractor->secondaryPhone      = $data['secondaryPhone'];
        $subcontractor->mainEmail           = $data['mainEmail'];
        $subcontractor->secondaryEmail      = $data['secondaryEmail'];
        $subcontractor->typeForm1099        = $data['typeForm1099'];

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
             return $rs  = ['alert' => 'success', 'message' => "Subcontratista Modificado "];
           } else {
               return $rs = ['alert' => 'error', 'message' => $error];
           }
    }
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
//             return $result = ['alert' => 'info', 'message' => 'Cliente Eliminado'];
//         } else {
//             return $result = ['alert' => 'error', 'message' => 'No se Puede Eliminar porque este registro tiene relacion con otros datos.'];
//         }
//     }
//------------------------------------------

 
}
