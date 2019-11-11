<?php

namespace App\Http\Controllers\web;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Country;
use App\Office;
use Auth;

class UserController extends Controller
{
    private $oUser;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oUser = new User;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->oUser->getAll();
        return view('module_configuration.users.index', compact('users'));
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
         $roles = Role::all();
         $permissions = Permission::orderBy('name')->get();
        return view('module_configuration.users.create',compact('roles','permissions'));
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
      // $this->oUser->changeOffice(Auth::user()->userId,$request->countryId,$request->officeId);
    	$country = Country::find($request->countryId);
    	$office  = Office::find($request->officeId);

        session(['countryId' => $country->countryId, 'countryName' => $country->countryName]);
        session(['officeId' => $office->officeId, 'officeName' =>$office->officeName]);

        $notification = array(
            'message'    => 'Se ha cambiado de Oficina el Usuario',
            'alert-type' => 'success',
        );

        return redirect()->route('home')
            ->with($notification);
    }
}
