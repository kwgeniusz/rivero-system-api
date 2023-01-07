<?php

namespace App\Http\Controllers\Web\Contracts;

use Auth;
use App\Models\Contracts\CommentTag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentTagController extends Controller
{
    private $oCommentTag;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oCommentTag = new CommentTag;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $commentTags = $this->oCommentTag->getAllByCompany(session('companyId'));

        if($request->ajax()) {
               return $commentTags;
        }

        return view('module_contracts.commentTags.index', compact('commentTags'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        // $clientNumberFormat = $this->oCompanyConfiguration->generateClientNumberFormat(session('companyId'),session('parentCompanyId'));
        // $contactTypes       = $this->oContactType->getAllByOffice(session('companyId'));
 
        // if($request->ajax()) {
        //  return [
        //          'clientNumberFormat' => $clientNumberFormat,
        //          'contactTypes' => $contactTypes
        //         ];
        //     }
        // return view('module_contracts.clients.create', compact('contactTypes','clientNumberFormat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        // if (Client::where('email', $email)->exists()) {
        //     // email encontrado
        //    }
        //    if (Client::where('email', $email)->exists()) {
        //     // email encontrado
        //    }    

        // $rs = $this->oCommentTag->insertClient(
        //     session('countryId'),
        //     session('companyId'),
        //     session('parentCompanyId'),
        //     $request->all()
        // );

        // if($request->ajax()){
        //         return $rs;
        //     }

        // $notification = array('alert-type' => $rs['alert'],'message'=> $rs['message']);
        // return redirect()->route('clients.index')->with($notification);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {

    //     $client       = $this->oCommentTag->findById($id, session('companyId'));
    //     $contactTypes = $this->oContactType->getAllByOffice(session('companyId'));

    //     return view('module_contracts.clients.edit', compact('client','contactTypes'));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$clientId)
    {
       
            //  $rs = $this->oCommentTag->updateClient(
            //    session('companyId'),
            //    $clientId,
            //    $request->all()
            //   );

            //   if($request->ajax()){
            //     return $rs;
            // }

        // $notification = array('alert-type' => $rs['alert'],'message' => $rs['message']);
        // return redirect()->route('clients.index')->with($notification);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        // $client = $this->oCommentTag->findById($id);

        //    if($request->ajax()){
        //       return $client;
        //     }
        // return view('module_contracts.clients.show', compact('client'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $result = $this->oCommentTag->deleteClient(session('countryId'),$id);

        //  $notification = array(
        //     'message'    => $result['message'],
        //     'alert-type' => $result['alert'],
        // );
        // return redirect()->route('clients.index')
        //     ->with($notification);
    }

}
