<?php

namespace App;

use App;
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
   public function getAll() {
      return $this->orderBy('transactionTypeId','ASC')->get();
   }
//------------------------------------------
   public function findById($id) {
        return $this->where('transactionTypeId', '=', $id)->get(); 
    }
//------------------------------------------
   public function findBySign($sign) {
        return $this->where('sign', '=', $sign)->get(); 
    }
//------------------------------------------
   public function insertTT($transactionTypeName,$sign) {
        
        $transactionType = new transactionType;
        $transactionType->transactionTypeName = $transactionTypeName;
        $transactionType->sign = $sign;
        $transactionType->save();
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
