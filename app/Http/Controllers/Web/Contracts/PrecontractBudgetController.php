<?php

namespace App\Http\Controllers\Web\Contracts;

use Auth;
use App\Models\Costs\Budget;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrecontractBudgetController extends Controller
{
    private $oBudget;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oBudget     = new Budget;
    }

    public function index(request $request,$id)
    {
        $budgets = $this->oBudget->getAllByPrecontract(session('countryId'),session('companyId'),$id);

        if($request->ajax()){
             return $budgets;
        }

        return view('module_contracts.precontracts.budgets.index', compact('id'));
    }

    // public function create()
    // {


    // }

    public function store(Request $request,$id)
    {
      $rs = $this->oDocument->insertF($request->file,'precontract',$id,$request->typeDoc);
    
       if ($rs->status() == 200) {
          return response('Insercion Exitosa', 200)->header('Content-Type', 'text/plain');
        } else {
           return response($rs->content(), 500)->header('Content-Type', 'text/plain');
        } 
    }

    // public function edit($id)
    // {
      
      
    // }

    // public function update(ContractRequest $request, $id)
    // {

   
    // }
    // public function show(Request $request,$id)
    // {

    // }

}
