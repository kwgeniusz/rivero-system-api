<?php

namespace App;

use Auth;
use DB;
use App\TransactionType;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
        public $timestamps = false;
    
        protected $table      = 'transaction';
        protected $primaryKey = 'transactionId';
        //  protected $dateFormat = 'Y-m-d';
        protected $fillable = [
         'transactionId',
         'transactionTypeId',
         'transactionDate',
         'description',
         'amount',  
         'bankId', 
         'reference'
        ];
    
    //--------------------------------------------------------------------
        /** Relations */
    //--------------------------------------------------------------------
       public function transactionType()
        {
          return $this->belongsTo('App\TransactionType','transactionTypeId','transactionTypeId');
        }
       public function bank()
        {
          return $this->belongsTo('App\Bank','bankId','bankId');
        }
 //--------------------------------------------------------------------
        /** Accesores y Mutadores */
//--------------------------------------------------------------------
    public function getTransactionDateAttribute($transactionDate) {
        if(empty($transactionDate))
        return $transactionDate = null;
    
        return $newDate = date("d/m/Y", strtotime($transactionDate));
        }
 //--------------------------------------------------------------------
        /** Function of Models */
//--------------------------------------------------------------------
        public function getAll()
        {
            return $this->orderBy('transactionId', 'ASC')->get();
        }

    //------------------------------------
        public function getAllForSign($transactionSign)
        {
            
            $result = $this->where('sign',$transactionSign)
                ->orderBy('transactionId', 'ASC')
                ->get();
    
            return $result;
        }
     //------------------------------------------
     public function getAllForTwoDate($date1,$date2)
     {
     $result = $this->where("transactionDate",">=",$date1)
     ->where("transactionDate","<=",$date2)
     ->orderBy('transactionId', 'ASC')
     ->get();

     return $result;
      }
    //------------------------------------------
        public function getAllForTwoDateAndSign($date1,$date2,$sign)
         {
         $result = $this->where("transactionDate",">=",$date1)
         ->where("transactionDate","<=",$date2)
         ->where("sign","=",$sign)
         ->orderBy('transactionId', 'ASC')
         ->get();
 
         return $result;
          }
    //------------------------------------------
        public function findById($id)
        {
            return $this->where('transactionId', '=', $id)->get();
        }

    //------------------------------------------
        public function insertT($transactionTypeId,$description,$transactionDate,$amount,$bankId,$reference,$sign,$month) {
       
         $error = null;

        DB::beginTransaction();
            try {
            $transaction    = new Transaction;
            $transaction->transactionTypeId     =      $transactionTypeId;
            $transaction->description           =      $description;
            $transaction->transactionDate       =      $transactionDate;
            $transaction->amount                =      $amount;
            $transaction->bankId                =      $bankId;
            $transaction->reference             =      $reference;
            $transaction->sign             =      $sign;
            $transaction->save();
            
            //REALIZA ACTUALIZACION EN BANCO
            if($sign == '+'){ 
                DB::table('bank')->where('bankId', $bankId)->increment('balance'.$month, $amount);
             }
             else{ 
               
               $balance = DB::table('bank')->where('bankId', $bankId)->value('balance'.$month);
                 if($balance < $amount){
                     throw new \Exception('ERROR: FONDOS INSUFICIENTES ');
                 }else{ 
                DB::table('bank')->where('bankId', $bankId)->decrement('balance'.$month, $amount);
                 }
             }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
             $success = false;
             $error = $e->getMessage();
             DB::rollback();
             }

             if ($success) 
             return "sin errores";
             else
             return $error;
 }
    //------------------------------------------
        public function updateT($contractId, $contractNumber, $clientId,
            $siteAddress, $contractDescription, $registryNumber, $startDate, $scheduledFinishDate,
            $actualFinishDate, $initialComment, $contractCost, $currencyName) {
    
            $this->where('contractId', $contractId)->update(array(
                'contractNumber'      => $contractNumber,
                'clientId'            => $clientId,
                'siteAddress'         => $siteAddress,
                'contractDescription' => $contractDescription,
                'registryNumber'      => $registryNumber,
                'startDate'           => $startDate,
                'scheduledFinishDate' => $scheduledFinishDate,
                'actualFinishDate'    => $actualFinishDate,
                'initialComment'      => $initialComment,
                'contractCost'        => $contractCost,
                'currencyName'        => $currencyName,
            ));
        }
    //------------------------------------------
        public function deleteT($id)
        {
            return $this->where('transactionId', '=', $id)->delete();
        }
    //-----------------------------------------
    
    
}
