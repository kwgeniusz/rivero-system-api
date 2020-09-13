<?php

namespace App\Http\Controllers\Web;

use Auth; 
use App\Term;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermController extends Controller
{
    private $oTerm;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oTerm = new Term;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
     $terms = $this->oTerm->getAllByCompany(session('companyId'));

           if($request->ajax()){
                return $terms;
            }

        return view('module_configuration.terms.index', compact('terms'));
    }

     public function store(Request $request)
    {

         $this->oTerm->insertT(
            session('countryId'),
            session('companyId'),
            $request->termName
        );

        $notification = array(
            'message'    => 'Registro Insertado Exitosamente',
            'alert-type' => 'success',
        );
         if($request->ajax()){
                return $notification;
            }
        return redirect()->route('terms.index')->with($notification);
    }
     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $term = $this->oTerm->findById($id);
        return view('module_configuration.terms.edit', compact('term'));
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
        $this->oTerm->updateT(
            $request->termId,
            $request->termName
        );

        $notification = array(
            'message'    => 'Termino Modificado',
            'alert-type' => 'success',
        );

        return redirect()->route('terms.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $term = $this->oTerm->findById($id);

         if($request->ajax()){
                return $term;
            }

        return view('module_configuration.terms.show', compact('term'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oTerm->deleteT($id);

        $notification = array(
            'message'    => 'Termino Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('terms.index')->with($notification);
    }

}
