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

    public function create()
    {
        return view('module_configuration.users.create');
    }

    public function store(Request $request)
    {
         $this->validate($request, 
            [
            'changeOffice' => 'required',
            'fullName'     => 'required|string',
            'userName'     => 'required|string',
            'email'        => 'string|email|max:255|unique:user',
            'password'     => 'required|min:6|confirmed',
            ]);

        $newUser = $this->oUser->insertU($request->all());

        $notification = array(
            'message'    => 'Usuario Agregado Exitosamente',
            'alert-type' => 'success',
        );

       return redirect()->route('users.index')->with($notification);
    }

    public function edit($userId)
    {
        $user   = $this->oUser->findById($userId);
        return view('module_configuration.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
           $this->validate($request, 
            [
            'changeOffice' => 'required',
            'fullName'     => 'required|string',
            'userName'     => 'required|string',
            'email'        => 'required|string|email|max:255',
            ]);

        $this->oUser->updateU($request->all(),$id);

        $notification = array(
            'message'    => 'Usuario Modificado Exitosamente',
            'alert-type' => 'success',
        );
        return redirect()->route('users.index')
            ->with($notification);
    }

    public function show(Request $request,$id)
    {

        //colocar error no puede ser el usuario actual.
        $user = $this->oUser->findById($id);

           if($request->ajax()){
              return $user;
            }
        return view('module_configuration.users.show', compact('user'));
    }

    public function destroy($id)
    {
        $this->oUser->deleteU($id);
        return redirect()->route('users.index')->with('info', 'Usuario Eliminado');
    }


  public function permissionsOfUser(Request $request)
    {
        $user = User::Find($request->userId);
        $permissions = Permission::orderBy('name')->get();
        
        return view('module_configuration.users.permissions',compact('user','permissions'));

    }
  public function addPermissions(Request $request)
    {
       
        $user = User::Find($request->userId);
        $user->syncPermissions($request->permissions);//borra permisos y coloca los nuevos.
        $user->countryId    = $request->countryId;
        $user->officeId     = $request->officeId;
        $user->changeOffice = $request->changeOffice;
        $user->save();

          $notification = array(
            'message'    => 'Se han actualizado los permisos',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
      //return Redirect::back()->withInput($request->all());

    }
    public function changeOffice(Request $request)
    {
        
    	$country = Country::find($request->countryId);
    	$office  = Office::find($request->officeId);

        session(['countryId' => $country->countryId,
                 'countryName' => $country->countryName,
                 'countryLanguage' => $country->countryConfiguration->language]);

        session(['officeId' => $office->officeId, 
                 'officeName' =>$office->officeName]);

        $notification = array(
            'message'    => 'Se ha cambiado de Oficina el Usuario',
            'alert-type' => 'success',
        );

        return redirect()->route('home')
            ->with($notification);
    }
}
