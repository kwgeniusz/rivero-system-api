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
    // public function index(Request $request)
    // {
    //     $comments = $this->oComment->getAll();
           
    //           if($request->ajax()){
    //             return $comments;
    //         }

    //     return view('module_configuration.projectuses.index', compact('comments'));
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function getAllByModel(Request $request)
    // {
    //     $comments = $this->oComment->getAllByContract($request->modelId);

    //         if($request->ajax()){
    //             return $comments;
    //         }
    // }
    // public function store(Request $request)
    // {

    //     // Auth::user()->comments()->create([
    //     //     'body' => $request->body,
    //     //     'commentable_id' => $post->id,
    //     //     'commentable_type' => get_class($post)
    //     // ]);
    //    $result = $this->oComment->insertC($request);
    //     return $result;
    // }



}
