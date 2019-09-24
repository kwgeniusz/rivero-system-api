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
        // $user = User::find(11);
//              $role = Role::find(3);
//         $user->assignRole('DIRECTOR');
//        // echo $user; 
//        // echo $user->getAllPermissions();
//        // echo $user->getAllPermissions();



// $role->givePermissionTo('A');
// $role->givePermissionTo('B');
// $role->givePermissionTo('BA');
// $role->givePermissionTo('BAA');
// $role->givePermissionTo('BAB');
// $role->givePermissionTo('BAC');
// $role->givePermissionTo('BB');
// $role->givePermissionTo('BBA');
// $role->givePermissionTo('BBB');
// $role->givePermissionTo('BBC');
// $role->givePermissionTo('BBD');
// $role->givePermissionTo('BBE');
// $role->givePermissionTo('BBF');
// $role->givePermissionTo('BC');
// $role->givePermissionTo('BCA');
// $role->givePermissionTo('BCB');
// $role->givePermissionTo('BCC');
// $role->givePermissionTo('BCD');
// $user->givePermissionTo('BCE');
// $user->givePermissionTo('BCF');
// $role->givePermissionTo('BCG');
// $role->givePermissionTo('BCH');
// $role->givePermissionTo('BCI');
// $role->givePermissionTo('BD');
// $role->givePermissionTo('BE');
// $role->givePermissionTo('BF');
// $role->givePermissionTo('BG');
// $role->givePermissionTo('C');
// $role->givePermissionTo('CA');
// $role->givePermissionTo('CB');
// $role->givePermissionTo('CC');
// $role->givePermissionTo('CD');
// $role->givePermissionTo('CE');
// $role->givePermissionTo('CF');
// $role->givePermissionTo('CG');
// $role->givePermissionTo('CH');
// $role->givePermissionTo('CI');
// $role->givePermissionTo('CJ');
// $role->givePermissionTo('D');
// $role->givePermissionTo('E');
// $role->givePermissionTo('F');
// $role->givePermissionTo('FA');
// $role->givePermissionTo('FB');
// $role->givePermissionTo('FC');
// $role->givePermissionTo('FD');
// $role->givePermissionTo('FE');
   if(!session()->has('countryId') && !session()->has('officeId') ) { 
session(['countryId' => Auth::user()->countryId, 'countryName' => Auth::user()->country->countryName]); 
session(['officeId' => Auth::user()->countryId, 'officeName' => Auth::user()->office->officeName]);
    }
   return view('home');
}

}