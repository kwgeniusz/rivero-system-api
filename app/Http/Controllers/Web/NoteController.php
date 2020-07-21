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
     
     $notes = $this->oNote->getAllByOffice(session('companyId'));

           if($request->ajax()){
                return $notes;
            }

        return view('module_configuration.notes.index', compact('notes'));
    }

     public function store(Request $request)
    {

         $this->oNote->insertN(
            session('countryId'),
            session('companyId'),
            $request->noteName
        );

        $notification = array(
            'message'    => 'Nota Creada Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('notes.index')
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
        $note = $this->oNote->findById($id);
        return view('module_configuration.notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->oNote->updateN(
            $request->noteId,
            $request->noteName
        );

        $notification = array(
            'message'    => 'Nota Modificada',
            'alert-type' => 'success',
        );

        return redirect()->route('notes.index')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $note = $this->oNote->findById($id);

         if($request->ajax()){
                return $note;
            }

        return view('module_configuration.notes.show', compact('note'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oNote->deleteN($id);

        $notification = array(
            'message'    => 'Nota Eliminada',
            'alert-type' => 'info',
        );

        return redirect()->route('notes.index')
            ->with($notification);
    }

}
