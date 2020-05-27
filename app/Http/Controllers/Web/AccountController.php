<?php

namespace App\Http\Controllers\Web;

use App\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth; 

class AccountController extends Controller
{
    private $oAccount;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oAccount = new Account;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$bankId)
    {
        $accounts    = $this->oAccount->getAllByBankAndOffice($bankId,session('officeId'));

            if($request->ajax()){
                 return $accounts;
            }

        return view('module_administration.accounts.index', compact('accounts'));
    }
//-------QUERYS ASINCRONIOUS-----------------//

}
