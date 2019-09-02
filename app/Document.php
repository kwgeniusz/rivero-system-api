<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    public $timestamps = false;

    protected $table      = 'document';
    protected $primaryKey = 'docId';
    protected $fillable = ['docId','docName','dateUploaded','docUrl','docNameOriginal','contractId','clientId'];

    // protected $dates = ['deleted_at'];

       //Type Document
    const PREVIOUS    = '1';
    const PROCESSED   = '2';
    const REVISED     = '3';
    const READY       = '4';

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
//     public function contract()
//     {
//         return $this->hasMany('App\Contract', 'clientId', 'clientId');
//     }
//     public function country()
//     {
//         return $this->belongsTo('App\Country', 'countryId', 'countryId');
//     }
//        public function contactType()
//     {
//         return $this->hasOne('App\ContactType', 'contactTypeId', 'contactTypeId');
//     }



// //--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
 public function getAllForContractAndType($contractId,$docType)
    {
        $result = $this->where('contractId', $contractId)
                       ->where('docType', $docType)
                       ->orderBy('docId', 'ASC')
                       ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('docId', '=', $id)->get();
    }
//------------------------------------------
    public function insert($file,$contractId,$typeDoc)
    {

        $error = null;
        DB::beginTransaction();
        try {
           $contract      = Contract::find($contractId);
           $directoryName = "D" . $contract->countryId . $contract->officeId . $contract->contractNumber;

             $name    = $file->getClientOriginalName();
             if($typeDoc == 1){ 
                $rs = Storage::putFile("docs/contracts/previous/$directoryName",  $file);
                 // $file->move(storage_path("app/public/docs/contracts/previous/$directoryName"), $name);
              }elseif ($typeDoc == 2) {
                $rs = Storage::putFile("docs/contracts/processed/$directoryName",  $file);
                // $file->move(storage_path("app/public/docs/contracts/processed/$directoryName"), $name);
              }elseif ($typeDoc == 3) {
                 $rs = Storage::putFile("docs/contracts/revised/$directoryName",  $file);
                // $file->move(storage_path("app/public/docs/contracts/processed/$directoryName"), $name);
              }elseif ($typeDoc == 4) {
                 $rs = Storage::putFile("docs/contracts/ready/$directoryName",  $file);
                // $file->move(storage_path("app/public/docs/contracts/processed/$directoryName"), $name);
              }
        $doc                        = new Document;
        $doc->docName               = $name;
        $doc->mimeType              = $file->extension();
        $doc->dateUploaded          = date('Y-m-d H:i:s');
        $doc->docUrl                = $rs;
        $doc->docNameOriginal       = $file->hashName();
        $doc->docType               = $typeDoc;
        $doc->contractId            = $contractId;
        $doc->clientId              = $contract->clientId;
        $doc->save();
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
          return response('Exitosa', 200)
                  ->header('Content-Type', 'text/plain');
        } else {
           return response($error, 500)
                  ->header('Content-Type', 'text/plain');
        } 
    }
    public function deleteFile($docId)
    {
        return $this->where('docId', '=', $docId)->delete();
    }

// //------------------------------------------
//     public function update($docId,$docName,$dateUploaded,$docUrl,$docNameOriginal,$contractId,$clientId)
//     {
//         $this->where('docId', $docId)->update(array(
//             'clientName'        => $clientName,
//             'clientDescription' => $clientDescription,
//             'clientAddress'     => $clientAddress,
//             'clientPhone'       => $clientPhone,
//             'clientEmail'       => $clientEmail,
//         ));
//     }
// //------------------------------------------
//------------------------------------------
}
