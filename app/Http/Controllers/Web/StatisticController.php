<?php

namespace App\Http\Controllers\Web;

use App;
use App\Contract;
use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class StatisticController extends Controller
{
    private $oContract;
    private $oClient;;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oContract        = new Contract;
        $this->oClient          = new Client;
    }

    public function numberOfClients()
    {
        $rs = $this->oClient->index();
           return count($rs);
    }
    public function numberOfContracts(Request $request)
    {
        $rs = $this->oContract->getAllForSixStatus(
            Contract::VACANT, 
            Contract::STARTED,
            Contract::READY_BUT_PENDING_PAYABLE,
            Contract::PROCESSING_PERMIT,
            Contract::WAITING_CLIENT,
            Contract::DOWNLOADING_FILES,
            $filteredOut,
            session('countryId'),
            session('officeId')
        );
           return count($rs);
    }
    public function numberOfContractsFinished(Request $request)
    {
        $rs = $this->oContract->getAllForStatus(Contract::FINISHED,$filteredOut,session('countryId'),session('officeId'));
           return count($rs);
    }
    public function numberOfContractsSuspended(Request $request)
    {
       $rs = $this->oContract->getAllForStatus(Contract::CANCELLED,$filteredOut,session('countryId'),session('officeId'));
           return count($rs);
    }


}
