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
    public function clientPendingInfo($clientId)
    {
        return $this->select('clientId', DB::raw('count(*) as cuotas'), DB::raw('sum(amountDue) as total'))
            ->where('pending', '=', 'Y')
            ->where('clientId', '=', $clientId)
            ->groupBy('clientId')
            ->get();
    }
//------------------------------------------
    public function contractsPendingAll($clientId)
    {
        $receivablesContracts = $this->select('sourceReference', 'receivableId', 'amountDue', 'countryId')
            ->where('pending', '=', 'Y')
            ->where('clientId', '=', $clientId)
            ->orderBy('sourceReference')
            ->get();

        return $receivablesContracts->groupBy('sourceReference');
    }
//------------------------------------------
    public function sharePending($contractId)
    {
        return $this->where('pending', '=', 'Y')
            ->where('contractId', '=', $contractId)
            ->orderBy('paymentContractId')
            ->get();

    }
//--------------------------------------------
    public function amountTotalContract($contractId)
    {
        return $this->select(DB::raw("SUM(amountDue) as amountTotal"))
            ->where('contractId', '=', $contractId)
            ->get();

    }
//------------------------------------------
    public function updateReceivable($receivableId, $amountPaid, $collectMethod, $sourceBank, $sourceBankAccount, $checkNumber, $targetBankId, $targetBankAccount, $datePaid)
    {
        $error   = null;
        $amountR = 0;

        DB::beginTransaction();
        try {
            //busca datos de la cuota que seleccione
            $receivable = $this->find($receivableId);
            //trae todas las cuotas del contrato, me sirve para saber si queda (01) y determinar que es la ultima cuota.
            $contractShares = $this->sharePending($receivable->contractId);
            //suma las cuotas restantes para sacar costo del contrato
            $contractCost = 0;
            foreach ($contractShares as $share) {
                $contractCost += $share->amountDue;
            }

            //error si es la ultima cuota mandame errores de montos.
            if (count($contractShares) == 1) {
                if ($amountPaid < $receivable->amountDue) {
                    throw new \Exception('Error: Ultima Cuota, El Monto es Insuficiente');
                } elseif ($amountPaid > $receivable->amountDue) {
                    throw new \Exception('Error: Ultima Cuota, El Monto a Cobrar es Muy Alto');
                }
                //error si lo pagado es igual o mayor que el costo del contrato.
            } elseif ($amountPaid >= $contractCost) {
                throw new \Exception('Error: El monto Ingresado No puede ser mayor o igual al costo Total del Contrato');
            }
            //comienza insercion de cuota
            // $contractShares[1] es la cuota que le sigue a la seleccionada
            if ($collectMethod == Receivable::CARD) {
                $amountPercentaje             = $amountPaid * 0.03;
                $receivable->amountPercentaje = $amountPercentaje;
            }
            $receivable->collectMethod     = $collectMethod;
            $receivable->sourceBank        = $sourceBank;
            $receivable->sourceBankAccount = $sourceBankAccount;
            $receivable->checkNumber       = $checkNumber;
            $receivable->targetBankId      = $targetBankId;
            $receivable->targetBankAccount = $targetBankAccount;
            $receivable->datePaid          = $datePaid;
            $receivable->pending           = 'N';
            //si lo pagado es menor que la cuota.
            if ($amountPaid < $receivable->amountDue) {

                $amountR                = $receivable->amountDue - $amountPaid;
                $receivable->amountDue  = $amountPaid;
                $receivable->amountPaid = $amountPaid;
                $receivable->save();
                $this->where('receivableId', $contractShares[1]->receivableId)->increment('amountDue', $amountR);
                //si lo paga es mayor
            } elseif ($amountPaid > $receivable->amountDue) {

                $amountR = $amountPaid - $receivable->amountDue;
                if ($amountR >= $contractShares[1]->amountDue) {
                    throw new \Exception('Error: No puede pagar Dos Cuotas simultaneamente, Monto Muy Alto');
                }
                $receivable->amountDue  = $amountPaid;
                $receivable->amountPaid = $amountPaid;
                $receivable->save();
                $this->where('receivableId', $contractShares[1]->receivableId)->decrement('amountDue', $amountR);

            } elseif ($amountPaid == $receivable->amountDue) {
                $receivable->amountDue  = $amountPaid;
                $receivable->amountPaid = $amountPaid;
                $receivable->save();
            }

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

        $result[] = $this->where("countryId", "=", $countryId)
            ->where("collectMethod", "=", '1')
            ->where("pending", "=", 'N')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where("collectMethod", "=", '2')
            ->where("pending", "=", 'N')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where("collectMethod", "=", '3')
            ->where("pending", "=", 'N')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();
        $result[] = $this->where("countryId", "=", $countryId)
            ->where("collectMethod", "=", '4')
            ->where("pending", "=", 'N')
            ->where("datePaid", ">=", $date1)
            ->where("datePaid", "<=", $date2)
            ->orderBy('collectMethod', 'ASC')
            ->get();

        //filtrando para eliminar resultados vacios del arreglo()
        $results = array_filter($result, function ($array) {
            foreach ($array as $value) {
                if ($value == []) {
                    return false;
                } else {
                    return true;
                }
            }
        });

        return $results;
    }
}
