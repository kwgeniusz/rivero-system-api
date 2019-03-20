<?php

namespace App;

use App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Receivable extends Model
{
    protected $table      = 'receivable';
    protected $primaryKey = 'receivableId';
    public $timestamps    = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receivableId',
        'countryId',
        'contractId',
        'clientId',
        'sourceReference',
        'amountDue',
        'amountPaid',
        'collectMethod',
        'sourceBank',
        'sourceBankAccount',
        'checkNumber',
        'targetBankId',
        'targetBankAccount',
        'datePaid',
        'pending',
    ];

    //COLLECTIONS METHOD
    const CASH     = '1';
    const CHECK    = '2';
    const CARD     = '3';
    const TRANSFER = '4';
//------------ACCESORES-----------------//
    public function getdatePaidAttribute($datePaid)
    {
        if (empty($datePaid)) {
            return $datePaid = null;
        }

        return $newDate = date("d/m/Y", strtotime($datePaid));
    }
    public function getCollectMethodAttribute($collectMethod)
    {

        if (App::getLocale() == 'es') {
            switch ($collectMethod) {
                case 1:
                    return "EFECTIVO";
                    break;
                case 2:
                    return "CHEQUE";
                    break;
                case 3:
                    return "TARJETA";
                    break;
                case 4:
                    return "TRANSFERENCIA";
                    break;
            }
        } else {
            switch ($collectMethod) {
                case 1:
                    return "CASH";
                    break;
                case 2:
                    return "CHECK";
                    break;
                case 3:
                    return "CARD";
                    break;
                case 4:
                    return "TRANSFER";
                    break;
            }
        }

    }
//------------MUTADORES-----------------//
    public function setDatePaidAttribute($datePaid)
    {
        if (empty($datePaid)) {
            return $datePaid = null;
        }
        $partes                       = explode("/", $datePaid);
        $arreglo                      = array($partes[2], $partes[1], $partes[0]);
        $date                         = implode("-", $arreglo);
        $this->attributes['datePaid'] = $date;
    }
//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function client()
    {
        return $this->hasMany('App\Client', 'clientId', 'clientId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function findById($id)
    {
        return $this->where('receivableId', '=', $id)->get();
    }
//--------------------------------------------
    public function clientsPending($countryId)
    {
        return $this->select('clientId', DB::raw('count(*) as cuotas'), DB::raw('sum(amountDue) as total'))
            ->where('pending', '=', 'Y')
            ->where('countryId', '=', $countryId)
            ->groupBy('clientId')
            ->get();
    }
//------------------------------------------
    public function clientPendingById($clientId)
    {
        return $this->select('clientId', DB::raw('count(*) as cuotas'), DB::raw('sum(amountDue) as total'))
            ->where('pending', '=', 'Y')
            ->where('clientId', '=', $clientId)
            ->groupBy('clientId')
            ->get();
    }
//------------------------------------------
    public function contractsPending($clientId)
    {
        $receivablesContracts = $this->select('sourceReference', 'receivableId', 'amountDue', 'countryId')
            ->where('pending', '=', 'Y')
            ->where('clientId', '=', $clientId)
            ->orderBy('sourceReference')
            ->get();

        return $receivablesContracts->groupBy('sourceReference');
    }
//------------------------------------------
    public function updateReceivable($receivableId, $amountDue, $collectMethod, $sourceBank, $sourceBankAccount, $checkNumber, $targetBankId, $targetBankAccount, $datePaid)
    {
        $error = null;

        DB::beginTransaction();
        try {
            //PAGAR CUOTA
            $receivable                    = Receivable::find($receivableId);
            $receivable->amountPaid        = $amountDue;
            $receivable->collectMethod     = $collectMethod;
            $receivable->sourceBank        = $sourceBank;
            $receivable->sourceBankAccount = $sourceBankAccount;
            $receivable->checkNumber       = $checkNumber;
            $receivable->targetBankId      = $targetBankId;
            $receivable->targetBankAccount = $targetBankAccount;
            $receivable->datePaid          = $datePaid;
            $receivable->pending           = 'N';
            $receivable->save();

            //REALIZA ACTUALIZACION EN BANCO
            $month = explode("-", $receivable->datePaid);
            DB::table('bank')->where('bankId', $targetBankId)->increment('balance' . $month[1], $amountDue);

            $success = true;
            DB::commit();
        } catch (\Exception $e) {
            $error   = $e->getMessage();
            $success = false;
            DB::rollback();
        }

        if ($success) {
            return $result = ['alert' => 'success', 'msj' => 'Cobro realizado Con Exito'];
        } else {
            return $result = ['alert' => 'error', 'msj' => $error];
        }

    }
    //------------------------------------------
    public function collections($countryId, $date1, $date2)
    {

        $result = $this->where("countryId", "=", $countryId)
            ->where("pending", "=", 'N')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('receivableId', 'ASC')
            ->get();

        return $result;
    }
}
