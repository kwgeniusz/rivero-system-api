<?php

namespace App\Http\Controllers\Web;

use Auth; 
use App\Note;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    private $oNote;

    public function __construct()
    {

        $this->middleware('auth');
        $this->oNote = new Note;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
     $notes = $this->oNote->getAllByLanguage(\Session::get('countryId'));

           if($request->ajax()){
                return $notes;
            }

        // return view('module_administration.banks.index', compact('banks', 'countrys'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {

    //     $this->oBank->insertB($request->bankName, session('countryId'));
    //     $notification = array(
    //         'message'    => "Banco $request->bankName Creado",
    //         'alert-type' => 'info',
    //     );
    //     return redirect()->route('banks.index')
    //         ->with($notification);
    // }
    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function edit($id)
    // {

    //     $bank = $this->oBank->findById($id,session('countryId'));
    //     return view('module_administration.banks.edit', compact('bank'));
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {

    //     $this->oBank->updateB($id, $request->bankName, $request->initialBalance, $request->balance01, $request->balance02, $request->balance03, $request->balance04, $request->balance05,
    //         $request->balance06, $request->balance07, $request->balance08, $request->balance09, $request->balance10, $request->balance11, $request->balance12);

    //     $notification = array(
    //         'message'    => "Banco $request->bankName Actualizado",
    //         'alert-type' => 'info',
    //     );
    //     return redirect()->route('banks.index')
    //         ->with($notification);
    // }
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {

    //     $bank = $this->oBank->findById($id,session('countryId'));
    //     return view('module_administration.banks.show', compact('bank'));
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {

    //    $result = $this->oBank->deleteB($id);

    //     $notification = array(
    //         'message'    => $result['msj'],
    //         'alert-type' => $result['alert'],
    //     );
    //     return redirect()->route('banks.index')
    //         ->with($notification);

    // }

}
