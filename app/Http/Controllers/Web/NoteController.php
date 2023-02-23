<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->oNote = new Note();
    }

    public function index(Request $request)
    {
        $notes = $this->oNote->getAllByOffice(session('companyId'));

        if ($request->ajax()) {
            return $notes;
        }

        return view('module_configuration.vue-notes.index', compact('notes'));
    }

    public function store(Request $request)
    {
        $note = new Note();

        $note->noteName = $request->noteName;
        $note->countryId = session('countryId');
        $note->companyId = session('companyId');

        $note->save();

        return $note;
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        $note->noteName = $request->noteName;

        $note->save();

        return $note;
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();
    }
}
