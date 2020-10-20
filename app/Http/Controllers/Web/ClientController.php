<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Client;
// use App\Country;
use App\ContactType;
use App\CompanyConfiguration;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $oClient;
    private $oCompanyConfiguration;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oClient = new Client;
        $this->oContactType = new ContactType;
        $this->oCompanyConfiguration = new CompanyConfiguration();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

      $clients = $this->oClient->getClientByGroupAndPagination(session('countryId'),session('companyId'),session('parentCompanyId'),$request->filteredOut);

        if($request->ajax()) {
             return $clients;
                }

         $clientsCompany = $this->oClient->getClientByCompany(session('companyId'),$request->filteredOut);

        return view('module_contracts.clients.index', compact('clientsCompany'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $clientNumberFormat = $this->oCompanyConfiguration->generateClientNumberFormat(session('companyId'),session('parentCompanyId'));
        $contactTypes       = $this->oContactType->getAllByOffice(session('companyId'));

        return view('module_contracts.clients.create', compact('contactTypes','clientNumberFormat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $rs = $this->oClient->insertClient(
            session('countryId'),
            session('companyId'),
            session('parentCompanyId'),
            $request->all()
        );

        if($request->ajax()){
                return $rs;
            }

        $notification = array('alert-type' => $rs['alert'],'message'=> $rs['msj']);

        return redirect()->route('clients.index')->with($notification);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $client       = $this->oClient->findById($id, session('companyId'));
        $contactTypes = $this->oContactType->getAllByOffice(session('companyId'));

        return view('module_contracts.clients.edit', compact('client','contactTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request,$clientId)
    {
             $rs = $this->oClient->updateClient(
               session('companyId'),
               $clientId,
               $request->all()
              );


        $notification = array('alert-type' => $rs['alert'],'message' => $rs['msj']);

        return redirect()->route('clients.index')->with($notification);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $client = $this->oClient->findById($id,session('companyId'));

           if($request->ajax()){
              return $client;
            }
        return view('module_contracts.clients.show', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->oClient->deleteClient(session('countryId'),$id);

         $notification = array(
            'message'    => $result['msj'],
            'alert-type' => $result['alert'],
        );
        return redirect()->route('clients.index')
            ->with($notification);
    }

//----------------QUERYS ASINCRONIOUS -------------->>>>
    public function get($client = '')
    {
        $results = $this->oClient->getClientByGroup(session('countryId'),session('companyId'),session('parentCompanyId'),$client);

        return json_encode($results);
    }
   public function getNumberFormat()
    {
        $clientNumberFormat = $this->oCompanyConfiguration->generateClientNumberFormat(session('companyId'),session('parentCompanyId'));
        return json_encode($clientNumberFormat);
    }

}
