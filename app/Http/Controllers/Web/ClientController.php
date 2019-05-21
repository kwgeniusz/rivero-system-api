<?php

namespace App\Http\Controllers\web;

use App\Client;
use App\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $oClient;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oClient = new Client;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $clients = $this->oClient->getAll();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys = Country::all();
        return view('clients.create', compact('countrys'));
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
            $request->countryId,
            $request->clientCode,
            $request->clientName,
            $request->clientAddress,
            $request->clientPhone,
            $request->clientEmail
        );

        $notification = array(
            'message'    => 'Cliente Creado Exitosamente',
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
        $countrys = Country::all();
        $client   = $this->oClient->findById($id);
        return view('clients.edit', compact('client', 'countrys'));
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
            $request->countryId,
            $request->clientCode,
            $request->clientName,
            $request->clientAddress,
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
        $client = $this->oClient->findById($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->oClient->deleteClient($id);

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

        $results = Client::select('clientId', 'clientName', 'clientAddress')
            ->where('clientName', 'LIKE', "%$client%")
            ->orderBy('clientName', 'ASC')
            ->get();
        return json_encode($results);

    }

}
