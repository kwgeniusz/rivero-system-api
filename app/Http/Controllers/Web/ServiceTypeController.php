<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    private $oServiceType;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oServiceType = new ServiceType;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = $this->oServiceType->getAll();
        return view('typesofservices.index', compact('services', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->oServiceType->insertST(
            $request->serviceTypeName
        );

        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->oServiceType->findById($id);
        return view('typesofservices.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->oServiceType->updateST($id,
            $request->serviceTypeName
        );

        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Actualizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = $this->oServiceType->findById($id);
        return view('typesofservices.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oServiceType->deleteST($id);
        return redirect()->route('services.index')
            ->with('info', 'Tipo de Proyecto Eliminado');
    }
}
