<?php

namespace App;

use Auth;
use DB;
use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Model;

class PaymentProposal extends Model
{
    protected $table      = 'payment_proposal';
    protected $primaryKey = 'paymentProposalId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paymentProposalId',
        'proposalId',
        'amount',
        'paymentDate',
        'dateCreated',
        'lastUserId',
    ];


//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function proposal()
    {
        return $this->belongsTo('App\Proposal', 'proposalId');
    }
//------------------------ACCESORES--------------------------------
    public function getAmountAttribute($amount)
    {
         return decrypt($this->attributes['amount']);
    }
    public function getPaymentDateAttribute($paymentDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Accesor');
         $newDate    = $oDateHelper->$functionRs($paymentDate);
        return $newDate;
    }
//------------------------MUTADORES--------------------------------

    public function setAmountAttribute($amount){
            $amount = number_format((float)$amount, 2, '.', '');
            return $this->attributes['amount'] = encrypt($amount);
     }
    public function setPaymentDateAttribute($paymentDate)
    {
         $oDateHelper = new DateHelper;
         $functionRs = $oDateHelper->changeDateForCountry(session('countryId'),'Mutador');
         $newDate    = $oDateHelper->$functionRs($paymentDate);

        $this->attributes['paymentDate'] = $newDate;
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByProposal($proposalId)
    {
        $result = $this->where('proposalId', $proposalId)
            ->orderBy('paymentProposalId', 'ASC')
            ->get();

        return $result;
    }
    public function addPayment($proposalId, $amount, $paymentDate)
    {
        $error = null;

        DB::beginTransaction();
        try {
            $acum = 0;
            $proposal     = Proposal::where('proposalId', $proposalId)->get();

            $payments =  PaymentProposal::where('proposalId', $proposalId)->get();
      
           //suma todas las cuotas y luego el monto que ingrese por formulario
          //para saber si esto es mayor que el monto de la factura
            foreach ($payments as  $payment) {
                $acum = $acum + $payment->amount;
            }
                $acum = $acum + $amount ;
           
              if ( $acum > $proposal[0]->netTotal)
              {
                throw new \Exception("Error: El total de Cuotas no debe sobrepasar el Monto de Factura.");
              }

            DB::table('proposal')->where('proposalId', $proposalId)->increment('pQuantity');  
            //INSERTA PAGO
            $payment              = new PaymentProposal;
            $payment->proposalId   = $proposalId;
            $payment->amount      = $amount;
            $payment->dateCreated = date('Y-m-d H:i:s');
            $payment->lastUserId  = Auth::user()->userId;
            $payment->save();

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Cuota Agregado Exitosamente'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }
//------------------------------------------
    public function removePayment($id,$proposalId)
    {
        $error = null;

        DB::beginTransaction();
        try {

                //ELIMINAR PAGO
                $this->where('paymentProposalId', '=', $id)->delete();
                DB::table('proposal')->where('proposalId', $proposalId)->decrement('pQuantity');  
        
                $success = true;
                DB::commit();
        
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'info', 'msj' => 'Cuota Eliminada'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }
    }

}
