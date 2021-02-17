<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\PerTrans;

class HrLoansController extends Controller
{
    private $oEmployes;
    private $oHistoryLoans;
    public function __construct()
    {
        $this->oEmployes = new PerTrans;
        $this->oHistoryLoans = new PerTrans;
    }
    public function getEmployees($country, $company)
    {
        $employess =  $this->oEmployes->getEmployees($country, $company);
        return $employess;
    }

    public function getHistoryLoans( $staffCode )
    {
        $historyLoans =  $this->oHistoryLoans->getHistoryLoans( $staffCode );
        return $historyLoans;
    }
    public function payLoans(Request $request)
    {
        // $loans =  PerTrans::fin($id);
        $PerTrans = PerTrans::find($request->id);
        $balanceCurrent = $PerTrans->balance - $request->balance;
        $PerTrans->balance = $balanceCurrent;
        
        $PerTrans->save();
        return $PerTrans;
    }
}
