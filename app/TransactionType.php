<?php

namespace App;

use App;
use DB;
use App\Transaction;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    public  $timestamps = false;

    protected $table ='transaction_type';
    protected $primaryKey = 'transactionTypeId';
    protected $fillable = [ 	
    'transactionTypeId',
    'transactionTypeName',
    'sign'
   ];


//--------------------------------------------------------------------
   /** Relations */
//--------------------------------------------------------------------  
public function transaction()
{
    return $this->hasMany('App\Transaction', 'transactionId');
}
//--------------------------------------------------------------------
 /** Accesores y Mutadores*/
//--------------------------------------------------------------------

   public function getSignAttribute($sign)
   {

       if (App::getLocale() == 'es') {
           switch ($sign) {
               case '+':
                   return "INGRESO (+)";
                   break;
               case '-':
                   return "EGRESO (-)";
                   break;
           }
       } else {
           switch ($sign) {
            case '+':
              return "INCOME (+)";
              break;
            case '-':
              return "EXPENSES (-)";
              break;
           }
       }

   }

//--------------------------------------------------------------------
 /** Function of Models */
//--------------------------------------------------------------------
//------------------------------------------
   public function findById($id) {
        return $this->where('transactionTypeId', '=', $id)->get(); 
    }
//------------------------------------------
    //esto me sirve para saber si la transaccion tiene el codigo COLLECTION O FEE
   public function findByOfficeAndCode($companyId,$transactionTypeCode) {
        return $this->where('companyId', '=', $companyId)
                    ->where('transactionTypeCode', '=', $transactionTypeCode)
                    ->get(); 
    }  
//------------------------------------------
       //esto es un getAllBySign
   public function getAllByOfficeAndSign($companyId,$sign) {
        return $this->where('companyId', '=', $companyId)
                    ->where('sign', '=', $sign)
                    ->get(); 
    }
//------------------------------------------
   public function insertTT($countryId, $companyId,$data) 
   {
    $error = null;

    DB::beginTransaction();
     try {
        // dd($data);
        // exit();
         //Insertar 
           $transactionType = new transactionType;
           $transactionType->countryId = $countryId;
           $transactionType->companyId = $companyId;
           $transactionType->transactionTypeName = $data['transactionTypeName'];
           $transactionType->sign                = $data['sign'];
           $transactionType->save();
           
           $success = true;
           DB::commit();
       } catch (\Exception $e) {

           $success = false;
           $error   = $e->getMessage();
           DB::rollback();
       }

       if ($success) {
         return $rs  = ['alert' => 'success', 'message' => "Tipo de Expense creado exitosamente"];
       } else {
           return $rs = ['alert' => 'error', 'message' => $error];
       }

    }
//------------------------------------------
    public function updateTT($transactionTypeId,$transactionTypeName) {		
        $this->where('transactionTypeId', $transactionTypeId)->update(array(
              'transactionTypeName'  => $transactionTypeName
        ));	
     }
//------------------------------------------
     public function deleteTT($transactionTypeId) {		
        return $this->where('transactionTypeId', '=', $transactionTypeId)->delete(); 	
     }	
//------------------------------------------
}
