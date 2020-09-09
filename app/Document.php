<?php

namespace App;

use Auth;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    public $timestamps = false;

    protected $table      = 'document';
    protected $primaryKey = 'docId';
    protected $fillable = ['docId','docName','dateUploaded','docUrl','docNameOriginal','contractId','clientId'];

    // protected $dates = ['deleted_at'];


//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function user()
    {
        return $this->hasMany('App\User', 'userId', 'userId');
    }
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
        $result = $this->with('user')
                       ->where('contractId', $contractId)
                       ->where('docType', $docType)
                       ->orderBy('dateUploaded', 'DESC')
                       ->get();

        return $result;
    }
//------------------------------------------
    public function findById($id)
    {
        return $this->where('docId', '=', $id)->get();
    }
//------------------------------------------
    public function insertF($file,$modelType,$modelId,$typeDoc)
    {

     $heicRs = preg_match('/.HEIC/', $file->getClientOriginalName());

        $error = null;
        DB::beginTransaction();
        try {
        $doc = new Document;
          // $request->file('file')->getSize();


     if($modelType == 'contract') { 
           $model               = Contract::find($modelId);
           $doc->contractId     = $modelId;
           $directoryName       = "D".$model->contractNumber;

             if($typeDoc == 'previous'){ 
                $rs = Storage::putFile("docs/contracts/previous/$directoryName",  $file);
              }elseif ($typeDoc == 'processed') {
                $rs = Storage::putFile("docs/contracts/processed/$directoryName",  $file);
              }elseif ($typeDoc == 'revised') {
                 $rs = Storage::putFile("docs/contracts/revised/$directoryName",  $file);
              }elseif ($typeDoc == 'ready') {
                 $rs = Storage::putFile("docs/contracts/ready/$directoryName",  $file);
                // $file->move(storage_path("app/public/docs/contracts/processed/$directoryName"), $name);
              }
      }elseif($modelType == 'precontract'){
             $model                 = Precontract::find($modelId);
             $doc->precontractId     = $modelId;
             $directoryName         = "D".$model->preId;

             $rs = Storage::putFile("docs/precontracts/$directoryName",  $file);

      }elseif($modelType == 'transaction') {
            $model                  = Transaction::find($modelId);
            $doc->transactionId     = $modelId;
          if($typeDoc == 'transactionsexpenses') {
             $rs = Storage::putFile("docs/administration/transactions/expenses",  $file);
          }

      }
        $doc->docName               = $file->getClientOriginalName();
        $doc->mimeType              = $file->extension();
        $doc->dateUploaded          = date('Y-m-d H:i:s');
        $doc->docUrl                = $rs;
        if($heicRs == 1){
         $doc->docNameOriginal       = '.HEIC';
        }else{
         $doc->docNameOriginal       = $file->hashName();
       }
        $doc->docType               = $typeDoc;
        $doc->userId                = Auth::user()->userId;
        $doc->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
          return response('Exitosa', 200)->header('Content-Type', 'text/plain');
        } else {
           return response($error, 500)->header('Content-Type', 'text/plain');
        } 
    }
    public function deleteF($docUrl,$docId)
    {
                 Storage::delete($docUrl);
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
