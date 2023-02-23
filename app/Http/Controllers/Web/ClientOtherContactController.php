<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\Client;
use App\ClientOtherContact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientOtherContactController extends Controller
{
    // private $oClient;
    private $oClientOtherContact;

    public function __construct()
    {
        $this->middleware('auth');
        // $this->oClient              = new Client;
        $this->oClientOtherContact  = new ClientOtherContact;
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $client  = Client::findOrfail($request->id);
       // $client = $this->oClient->findById($request->id,session('countryId'),session('companyId'));
        $otherContact = $client->otherContact()->get();

            if($request->ajax()){
                return $otherContact;
            }
        // return view('module_configuration.projectuses.index', compact('otherContact'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $rs = $this->oClientOtherContact->insertC($id,$request->all());
        return $rs;
    }

    public function update(Request $request,$id)
    {
          $rs = $this->oClientOtherContact->updateC(
               $id,
               $request->all()
              );

              if($request->ajax()){
                return $rs;
              }
    }   
   /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = $this->oClientOtherContact->findById($id);

              return $client;
    }

    public function destroy($id)
    {
        $rs = $this->oClientOtherContact->deleteC($id);

         return $rs;
    }
}
