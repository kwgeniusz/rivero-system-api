<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->oTerm = new Term();
    }

    public function index(Request $request)
    {
        $terms = $this->oTerm->getAllByCompany(session('companyId'));

        if ($request->ajax()) {
            return $terms;
        }

        return view('module_configuration.vue-terms.index', compact('terms'));
    }

    public function store(Request $request)
    {
        $term = new Term();

        $term->termName = $request->termName;
        $term->countryId = session('countryId');
        $term->companyId = session('companyId');

        $term->save();

        return $term;
    }

    public function update(Request $request, $id)
    {
        $term = Term::findOrFail($id);

        $term->termName = $request->termName;

        $term->save();

        return $term;
    }

    public function destroy($id)
    {
        $term = Term::findOrFail($id);
        $term->delete();
    }
}
