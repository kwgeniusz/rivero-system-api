<?php

namespace App\Http\Controllers\web;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
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

             // $user = User::find(2);
             // $user->givePermissionTo('edit articles');
   // $role = Role::create(['name' => 'writer']);
   // $permission = Permission::create(['name' => 'edit articles']);
   //  $role->givePermissionTo($permission);

        return view('users.index', compact('users'));
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
