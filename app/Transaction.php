<?php

namespace App;

use App\TransactionType;
use DB;
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
        'countryId',
        'officeId',
        'transactionDate',
        'description',
        'amount',
        'bankId',
        'reference',
    ];

    //--------------------------------------------------------------------
               /** RELATIONS */
    //--------------------------------------------------------------------
    public function transactionType()
    {
        return $this->belongsTo('App\TransactionType', 'transactionTypeId', 'transactionTypeId');
    }
    public function bank()
    {
        return $this->belongsTo('App\Bank', 'bankId', 'bankId');
    }
    //--------------------------------------------------------------------
               /** ACCESORES **/
   //--------------------------------------------------------------------
    public function getAmountAttribute($amount)
    {
        return decrypt($amount);
    }
    public function getTransactionDateAttribute($transactionDate)
    {
        if (empty($transactionDate)) {
            return $transactionDate = null;
        }
        return $newDate = date("d/m/Y", strtotime($transactionDate));
    }

    // ------------MUTADORES-----------------//
    public function setAmountAttribute($amount)
    {
        return $this->attributes['amount'] = encrypt($amount);
    }
    public function setTransactionDateAttribute($transactionDate)
    {
        if (empty($transactionDate)) {
            return $transactionDate = null;
        }
        $partes                              = explode("/", $transactionDate);
        $arreglo                             = array($partes[2], $partes[1], $partes[0]);
        $date                                = implode("-", $arreglo);
        $this->attributes['transactionDate'] = $date;
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAll()
    {
        return $this->orderBy('transactionId', 'ASC')->get();
    }
    //------------------------------------
    public function getAllForSign($transactionSign,$countryId,$officeId)
    {

        $result = $this->where('sign', $transactionSign)
                      ->where('countryId', $countryId)
                      ->where('officeId', $officeId) 
            ->orderBy('transactionId', 'ASC')
            ->get();

        return $result;
    }
    //------------------------------------------
    public function getAllForTwoDate($date1, $date2,$countryId,$officeId)
    {
        $result = $this->where("transactionDate", ">=", $date1)
            ->where("transactionDate", "<=", $date2)
            ->where('countryId', $countryId)
             ->where('officeId', $officeId) 
            ->orderBy('transactionId', 'ASC')
            ->get();

        return $result;
    }
    //------------------------------------------
    public function getAllForTwoDateAndSign($date1, $date2, $sign,$countryId,$officeId)
    {
        $result = $this->where("transactionDate", ">=", $date1)
            ->where("transactionDate", "<=", $date2)
            ->where("sign", "=", $sign)
            ->where('countryId', $countryId)
            ->where('officeId', $officeId) 
            ->orderBy('transactionId', 'ASC')
            ->get();

        return $result;
    }
    //------------------------------------------
    public function findById($id,$countryId,$officeId)
    {
        return $this->where('transactionId', '=', $id)
                      ->where('countryId', $countryId)
                      ->where('officeId', $officeId) 
                      ->get();
    }

    //------------------------------------------
    public function insertT($transactionTypeId, $description, $transactionDate, $amount, $bankId, $reference, $sign, $month,$countryId,$officeId)
    {

        $error = null;

        DB::beginTransaction();
        try {
            //INSERTA UNA NUEVA TRANSACTION
            $transaction                    = new Transaction;
            $transaction->countryId         = $countryId;
            $transaction->officeId          = $officeId;
            $transaction->transactionTypeId = $transactionTypeId;
            $transaction->description       = $description;
            $transaction->transactionDate   = $transactionDate;
            $transaction->amount            = $amount;
            $transaction->bankId            = $bankId;
            $transaction->reference         = $reference;
            $transaction->sign              = $sign;
            $transaction->save();
            
            //REALIZA ACTUALIZACION EN BANCO
            $oBank = new Bank;
            $oBank->updateBalanceForBank($sign, $bankId, $month, $amount);
            
            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Transaccion Exitosa'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }
    //------------------------------------------
    public function deleteT($id)
    {      
        $error = null;
        DB::beginTransaction();
        try {
            //FALTA QUE CUANDO ELIMINE LA TRANSACION DESCUENTE O SUME DE BANK 
                $transaction   = Transaction::find($id);
              //  $oBank = new Bank;
              //  $oBank->updateBalanceForBank($transaction->sign, $transaction->bankId, $month, $transaction->$amount);
                $transaction->delete();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Transaccion Eliminada'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }
    }
    //-----------------------------------------

}
