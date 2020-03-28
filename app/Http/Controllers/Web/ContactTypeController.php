<?php

namespace App\Http\Controllers\Web;

use App\ContactType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactTypeController extends Controller
{
	private $oContactType;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oContactType = new ContactType;
    }

   public function index(Request $request)
    {
       $contactTypes = $this->oContactType->getAllByOffice(session('officeId'));

           if($request->ajax()){
                return $contactTypes;
            }

        return view('module_configuration.contactTypes.index', compact('contactTypes'));
    }

     public function store(Request $request)
    {

         $this->oContactType->insertCT(
            session('countryId'),
            session('officeId'),
            $request->contactTypeName
        );

        $notification = array(
            'message'    => 'Tipo de Contacto Creado Exitosamente',
            'alert-type' => 'success',
        );

        return redirect()->route('contactTypes.index')
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
        $contactType = $this->oContactType->findById($id);
        return view('module_configuration.contactTypes.edit', compact('contactType'));
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
        $this->oContactType->updateCT(
            $request->contactTypeId,
            $request->contactTypeName
        );

        $notification = array(
            'message'    => 'Tipo de Contacto Modificado',
            'alert-type' => 'success',
        );

        return redirect()->route('contactTypes.index')
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
        $contactType = $this->oContactType->findById($id);

         if($request->ajax()){
                return $contactType;
            }

        return view('module_configuration.contactTypes.show', compact('contactType'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oContactType->deleteCT($id);

        $notification = array(
            'message'    => 'Tipo de Contacto Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('contactTypes.index')
            ->with($notification);
    }
}
