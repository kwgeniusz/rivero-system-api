<?php

namespace App\Http\Controllers\Web;

use App\Client;
use App\Country;
use App\ContactType;
use App\Configuration;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Auth;

class ClientController extends Controller
{
    private $oClient;
    private $oConfiguration;
    private $module;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware("permission:BA");
        $this->oClient = new Client;
        $this->oConfiguration = new Configuration();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       $filteredOut = $request->filteredOut;
 

       $clients = Client::orderBy('cltId', 'ASC')
                         ->filter($filteredOut)
                         ->where('countryId','=', session('countryId'))
                         ->paginate(100);

        return view('module_contracts.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $clientNumberFormat = $this->oConfiguration->generateClientNumberFormat(session('countryId'),session('officeId'));
        // $countrys     = Country::all();
        $contactTypes = ContactType::all();

        return view('module_contracts.clients.create', compact('countrys','contactTypes','clientNumberFormat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $clients = $this->oClient->insertClient(
            session('countryId'),
            session('officeId'),
            $request->clientName,
            $request->clientAddress,
            $request->contactTypeId, 
            $request->clientPhone,
            $request->clientEmail
        );

        if($request->ajax()){
                return $clients;
            }
            
        $notification = array(
            'message'    => 'Cliente Creado Exitosamente '.$clients->clientCode,
            'alert-type' => 'success',
        );

        return redirect()->route('clients.index')
                         ->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $countrys = Country::all();
        $contactTypes = ContactType::all();
        $client   = $this->oClient->findById($id, session('countryId'));

        return view('module_contracts.clients.edit', compact('client', 'countrys','contactTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, $id)
    {
        $this->oClient->updateClient($id,
            session('countryId'),
            session('officeId'),
            $request->clientName,
            $request->clientAddress,
            $request->contactTypeId,  
            $request->clientPhone,
            $request->clientEmail
        );
        $notification = array(
            'message'    => 'Cliente Modificado Exitosamente',
            'alert-type' => 'success',
        );
        return redirect()->route('clients.index')
            ->with($notification);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->oClient->findById($id,session('countryId'));
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
        $result = $this->oClient->deleteClient($id,session('countryId'));

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
        $results = Client::select('clientId', 'clientName', 'clientAddress','clientCode')
            ->where('clientName', 'LIKE', "%$client%")
            ->where('countryId', session('countryId'))
            ->orWhere('clientCode', 'LIKE', "%$client%")
            ->where('countryId', session('countryId')) 
            ->orderBy('clientName', 'ASC')
            ->get();

        return json_encode($results);
    }
   public function getNumberFormat()
    {
        $clientNumberFormat = $this->oConfiguration->generateClientNumberFormat(session('countryId'),session('officeId'));
        return json_encode($clientNumberFormat);
    }

}
