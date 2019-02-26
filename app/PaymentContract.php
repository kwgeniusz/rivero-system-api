<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class PaymentContract extends Model
{
    protected $table      = 'payment_contract';
    protected $primaryKey = 'paymentContractId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paymentContractId',
        'contractId',
        'amount',
        'paymentDate',
        'dateCreated',
        'lastUserId',
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function contract()
    {
        return $this->belongsTo('App\Contract', 'contractId');
    }

//------------------------ACCESORES--------------------------------
    //--------------------------------------------------------------------
    public function getPaymentDateAttribute($paymentDate)
    {
        if (empty($paymentDate)) {
            return $paymentDate = null;
        }

        return $newDate = date("d/m/Y", strtotime($paymentDate));
    }
//------------------------MUTADORES--------------------------------
    //--------------------------------------------------------------------
    public function setPaymentDateAttribute($paymentDate)
    {
        if (empty($paymentDate)) {
            return $paymentDate = null;
        }
        $partes                          = explode("/", $paymentDate);
        $arreglo                         = array($partes[2], $partes[1], $partes[0]);
        $date                            = implode("-", $arreglo);
        $this->attributes['paymentDate'] = $date;
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllForContract($contractId)
    {
        $result = $this->where('contractId', $contractId)
            ->orderBy('paymentContractId', 'ASC')
            ->get();

        return $result;
    }
    public function aggPayment($contractId, $amount, $paymentDate)
    {
        $error = null;

        DB::beginTransaction();
        try {
            //INSERTA PAGO

            $payment              = new PaymentContract;
            $payment->contractId  = $contractId;
            $payment->amount      = $amount;
            $payment->paymentDate = $paymentDate;
            $payment->dateCreated = date('Y-m-d H:i:s');
            $payment->lastUserId  = Auth::user()->userId;
            $payment->save();

            //REALIZA ACTUALIZACION EN ContractCost
            $rs = DB::table('contract')->where('contractId', $contractId)->increment('contractCost', $amount);

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Pago Exitoso'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }
//------------------------------------------
    public function removePayment($id, $amount, $contractId)
    {
        $error = null;

        DB::beginTransaction();
        try {
            //ELIMINAR PAGO
            $this->where('paymentContractId', '=', $id)->delete();
            //REALIZA ACTUALIZACION EN ContractCost
            $rs = DB::table('contract')->where('contractId', $contractId)->decrement('contractCost', $amount);

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Pago Eliminado'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }
    }

}
