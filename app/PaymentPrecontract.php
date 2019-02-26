<?php

namespace App;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Model;

class PaymentPrecontract extends Model
{
    protected $table      = 'payment_precontract';
    protected $primaryKey = 'paymentPrecontractId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paymentPrecontractId',
        'precontractId',
        'amount',
        'paymentDate',
        'dateCreated',
        'lastUserId',
    ];
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function precontract()
    {
        return $this->belongsTo('App\Precontract', 'precontractId');
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
    public function getAllForPrecontract($precontractId)
    {
        $result = $this->where('precontractId', $precontractId)
            ->orderBy('paymentPrecontractId', 'ASC')
            ->get();

        return $result;
    }
    public function aggPayment($precontractId, $amount, $paymentDate)
    {
        $error = null;

        DB::beginTransaction();
        try {
            //INSERTA PAGO

            $payment                = new PaymentPrecontract;
            $payment->precontractId = $precontractId;
            $payment->amount        = $amount;
            $payment->paymentDate   = $paymentDate;
            $payment->dateCreated   = date('Y-m-d H:i:s');
            $payment->lastUserId    = Auth::user()->userId;
            $payment->save();

            //REALIZA ACTUALIZACION EN ContractCost
            $rs = DB::table('pre_contract')->where('precontractId', $precontractId)->increment('precontractCost', $amount);

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
    public function removePayment($id, $amount, $precontractId)
    {
        $error = null;

        DB::beginTransaction();
        try {
            //ELIMINAR PAGO
            $this->where('paymentPrecontractId', '=', $id)->delete();
            //REALIZA ACTUALIZACION EN ContractCost
            $rs = DB::table('pre_contract')->where('precontractId', $precontractId)->decrement('precontractCost', $amount);

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
