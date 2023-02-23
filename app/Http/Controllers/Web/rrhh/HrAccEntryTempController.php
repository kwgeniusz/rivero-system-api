<?php

namespace App\Http\Controllers\Web\rrhh;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\human_resources\HrAccTransactionHeader;
use App\Models\human_resources\HrAccTransaction;
use Carbon\Carbon;

class HrAccEntryTempController extends Controller
{

    public function store(Request $request)
    {
        
        // Logica para genear asientos contables temporales desde NOMINA

        // parametros de entrada: opcion por pantalla
        $countryId = $request->countryId;
        $companyId = $request->companyId;
        $year = $request->year;
        $payrollNumber = $request->payrollNumber;
        // $entryDate

        // Seleccionar source code. Manuelmente
        $sourceCode = $request->sourceCode;

        // total de la cabecera
        $totalDebit  = 0;
        $totalCredit = 0;

        // grabar registro cabecera y obtener id
        $insertHeader = new HrAccTransactionHeader([
            'countryId' => $countryId,
            'companyId' => $companyId,
            'entryNumber' => 0,
            'entryDate' => Carbon::now(),
            'entryDescription' => '',
            'totalDebit' => 0,
            'totalCredit' => 0,
            'validation' => 0,
            'entryUpdated' => 0,
            'source' => $sourceCode,
        ]);
        $insertHeader->save(); 
        // return $insertHeader->headerId;
        // Leer las transacciones de nomina. Depende del modulo
        $payrollHistory = HrAccTransactionHeader::getPayrollHistoryByPeriod($companyId, $countryId, $year, $payrollNumber);

        // Procesar las trasacciones. Depende del módudlo
        foreach($payrollHistory  as $rs1) {
            $transactionTypeCode = $rs1->transactionTypeCode; 
            $amount              = $rs1->amount; 

            // buscar la equivalencia contable
            $rsAccEquivalence = HrAccTransactionHeader::transactionTypeCode( $transactionTypeCode );
            
            foreach($rsAccEquivalence as $rs2) {
                $debitAccount   = $rs2->debitAccount;
                $creditAccount  = $rs2->creditAccount;

                $debit = 0;
                $credit = 0;

                if ($debitAccount != "" ) {
                    $generalLedgerId = HrAccTransactionHeader::GetGeneralLedgerId( $debitAccount );
                    // return $generalLedgerId['generalLedgerId'];

                    // insertar registro en transaccion tmp
                    $debit = $amount;
                    $totalDebit = $totalDebit + $debit;
                    // grabar registro temporal
                    $insertAccoun = new HrAccTransaction([
                        'countryId' => $countryId,
                        'companyId' => $companyId,
                        'headerId' => $insertHeader->headerId,
                        'generalLedgerId' => $generalLedgerId['generalLedgerId'],
                        'transactionDate' => Carbon::now(),
                        'transactionDescription' => '',
                        'transactionReference' => '',
                        'debit' => $debit,
                        'credit' => 0,
                        'userId' => 1,
                    ]);
                    $insertAccoun->save();
                }

                $debit = 0;
                $credit = 0;

                if ($creditAccount != "" ) {
                    $generalLedgerId = HrAccTransactionHeader::GetGeneralLedgerId( $creditAccount );

                    // insertar registro en transaccion tmp
                    $credit = $amount;
                    $totalCredit = $totalCredit + $credit;
                    // grabar registro temporal
                    $insertAccoun = new HrAccTransaction([
                        'countryId' => $countryId,
                        'companyId' => $companyId,
                        'headerId' => $insertHeader->headerId,
                        'generalLedgerId' => $generalLedgerId['generalLedgerId'],
                        'transactionDate' => Carbon::now(),
                        'transactionDescription' => 'ssa',
                        'transactionReference' => 'as',
                        'debit' => 0,
                        'credit' => $credit,
                        'userId' => 1,
                    ]);
                    $insertAccoun->save();
                }

            }

        }

        // fin del proceso. ACtualizar cabecera
        $activity = HrAccTransactionHeader::findOrFail($insertHeader->headerId);
        $activity->update(array(
            'totalDebit' => $totalDebit,
            'totalCredit' => $totalCredit,
        ));

        return response()->json(['data' => ['message' => 'Asientos temporales generados']], 200);
        
    }
}