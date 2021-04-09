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
    public function company()
    {
        return $this->belongsTo('App\Company', 'companyId', 'companyId');
    }
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
        
     $year = date("Y");
     $companyName = session('companyName');
     $heicRs = preg_match('/.HEIC/', $file->getClientOriginalName());

    //    dd($file);
    //    exit();
     $image = new \Imagick();
     $image->readImageBlob($file);
     $image->setImageFormat("jpeg");
     $image->setImageCompressionQuality(100);
     $image->writeImage($targetdir.$uid.".jpg"); 

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
                $rs = Storage::putFile("$companyName/$year/mod_contracts/contracts/previous/$directoryName",  $file);
              }elseif ($typeDoc == 'processed') {
                $rs = Storage::putFile("$companyName/$year/mod_contracts/contracts/processed/$directoryName",  $file);
              }elseif ($typeDoc == 'revised') {
                 $rs = Storage::putFile("$companyName/$year/mod_contracts/contracts/revised/$directoryName",  $file);
              }elseif ($typeDoc == 'ready') {
                 $rs = Storage::putFile("$companyName/$year/mod_contracts/contracts/ready/$directoryName",  $file);
                // $file->move(storage_path("app/public/docs/contracts/processed/$directoryName"), $name);
              }
      }elseif($modelType == 'precontract'){
             $model                 = Precontract::find($modelId);
             $doc->precontractId     = $modelId;
             $directoryName         = "D".$model->preId;

             $rs = Storage::putFile("$companyName/$year/mod_contracts/precontracts/$directoryName",  $file);

      }elseif($modelType == 'transaction') {
            $model                  = Transaction::find($modelId);
            $doc->transactionId     = $modelId;
          if($typeDoc == 'expense') {
             $rs = Storage::putFile("$companyName/$year/mod_administration/transactions/expenses",  $file);
          }

      }
        $doc->docName               = $file->getClientOriginalName();
        $doc->dateUploaded          = date('Y-m-d H:i:s');
        $doc->docUrl                = $rs;
        if($heicRs == 1){
         $doc->docNameOriginal       =  '1';
         $doc->mimeType              = '.HEIC';
        }else{
         $doc->docNameOriginal       = $file->hashName();
         $doc->mimeType              = $file->extension();
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

    public function moveF($docId,$docUrl,$docTypeOld,$docTypeNew)
    {
        $error = null;

        DB::beginTransaction();
        try {
            
           $word1 = "/$docTypeOld/";
           $word2 = "/$docTypeNew/";
           $docUrlNew = str_replace($word1,$word2,$docUrl);
           Storage::move($docUrl, $docUrlNew);

           $doc              = Document::find($docId);
           $doc->docUrl      = $docUrlNew; 
           $doc->docType     = $docTypeNew; 
           $doc->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

      if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Operacion Exitosa'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }
       
    } 

    public function moveToContract($contract,$doc)
    {
        $error = null;
    
        DB::beginTransaction();
        try {
           $year                = date("Y");
           $companyName         = session('companyName');
           $directoryName       = "D".$contract->contractNumber;
           $docUrlNew           = "$companyName/$year/mod_contracts/contracts/previous/$directoryName/$doc->docNameOriginal";

           Storage::move($doc->docUrl, $docUrlNew);

           $doc                 = Document::find($doc->docId);
           $doc->docUrl         = $docUrlNew; 
           $doc->precontractId  = null; 
           $doc->contractId     = $contract->contractId; 
           $doc->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

      if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Operacion Exitosa'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
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
