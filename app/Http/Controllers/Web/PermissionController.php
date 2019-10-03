<?php

namespace App\Http\Controllers\Web;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PermissionController extends Controller
{ 

    public function __construct()
    {

        $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('users.roles.index', compact('roles'));
    }
   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        // $clientNumberFormat = $this->oConfiguration->generateClientNumberFormat(Auth::user()->countryId);
        // $countrys     = Country::all();
        // $contactTypes = ContactType::all();

        return view('users.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->oUser->insertST(
        //     $request->serviceTypeName
        // );

        // return redirect()->route('services.index')
        //     ->with('info', 'Tipo de Proyecto Creado');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $service = $this->oUser->findById($id);
        // return view('typesofservices.edit', compact('service'));
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
        // $this->oUser->updateST($id,
        //     $request->serviceTypeName
        // );

        // return redirect()->route('services.index')
        //     ->with('info', 'Tipo de Proyecto Actualizado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $service = $this->oUser->findById($id);
        // return view('typesofservices.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $this->oUser->deleteST($id);
        // return redirect()->route('services.index')
        //     ->with('info', 'Tipo de Proyecto Eliminado');
    }


    public function changeOffice(Request $request)
    {
        $this->oUser->changeOffice(Auth::user()->userId,$request->countryId,$request->officeId);
       
        $notification = array(
            'message'    => 'Se ha cambiado de Oficina el Usuario',
            'alert-type' => 'success',
        );

        return redirect()->route('home')
            ->with($notification);
    }
}
