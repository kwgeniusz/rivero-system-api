<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\User;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $permissions = Permission::orderBy('name')->get();
        // $user = User::find(20);
             // $role = Role::find(3);
//         $user->assignRole('DIRECTOR');
//        // echo $user; 
        // echo $user->getAllPermissions();
        // exit();
//        // echo $user->getAllPermissions();
 
         // $role->givePermissionTo('F');
         // $role->revokePermissionTo('A');
// $user->givePermissionTo('A');
// $user->givePermissionTo('B');
// $user->givePermissionTo('BA');
// $user->givePermissionTo('BAA');
// $user->givePermissionTo('BAB');
// $user->givePermissionTo('BAC');
// $user->givePermissionTo('BB');
// $user->givePermissionTo('BBA');
// $user->givePermissionTo('BBB');
// $user->givePermissionTo('BBC');
// $user->givePermissionTo('BBD');
// $user->givePermissionTo('BBE');
// $user->givePermissionTo('BBF');
// $user->givePermissionTo('BC');
// $user->givePermissionTo('BCA');
// $user->givePermissionTo('BCB');
// $user->givePermissionTo('BCC');
// $user->givePermissionTo('BCD');
// $user->givePermissionTo('BCE');
// $user->givePermissionTo('BCF');
// $user->givePermissionTo('BCG');
// $user->givePermissionTo('BCH');
// $user->givePermissionTo('BCI');
// $user->givePermissionTo('BD');
// $user->givePermissionTo('BE');
// $user->givePermissionTo('BF');
// $user->givePermissionTo('BG');
// $user->givePermissionTo('C');
// $user->givePermissionTo('CA');
// $user->givePermissionTo('CB');
// $user->givePermissionTo('CC');
// $user->givePermissionTo('CD');
// $user->givePermissionTo('CE');
// $user->givePermissionTo('CF');
// $user->givePermissionTo('CG');
// $user->givePermissionTo('CH');
// $user->givePermissionTo('CI');
// $user->givePermissionTo('CJ');
// $user->givePermissionTo('D');
// $user->givePermissionTo('E');
// $user->givePermissionTo('F');
// $user->givePermissionTo('FA');
// $user->givePermissionTo('FB');
// $user->givePermissionTo('FC');
// $user->givePermissionTo('FD');
// $user->givePermissionTo('FE');

   //COMPROBACION CADA VEZ QUE EXISTE UN NUEVO A'O RESETEA EL CONTEADOR DE CONFIGURACION DE PROJECT

   return view('home');
}

}