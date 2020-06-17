<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Comment;

class CommentController extends Controller
{
    private $oComment;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oComment = new Comment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $comments = $this->oComment->getAll();
           
              if($request->ajax()){
                return $comments;
            }

        return view('module_configuration.projectuses.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $result = $this->oComment->insertC($request);

        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->oComment->updateST($id,
            $request->projectUseName
        );

        $notification = array(
            'message'    => 'Uso de Proyecto Modificado',
            'alert-type' => 'success',
        );

        return redirect()->route('projectUses.index')
            ->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $project = $this->oComment->findById($id);

         if($request->ajax()){
                return $project;
            }
        return view('module_configuration.projectuses.show', compact('project'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->oComment->deleteST($id);

        $notification = array(
            'message'    => 'Uso de Proyecto Eliminado',
            'alert-type' => 'info',
        );

        return redirect()->route('projectUses.index')
            ->with($notification);
    }

    public function getAllByModel(Request $request)
    {

        $comments = $this->oComment->getAllByContract($request->contractId);
           
              if($request->ajax()){
                return $comments;
            }
    }

}
