<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use App\Precontract;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrecontractCommentController extends Controller
{
    private $oPrecontract;
    private $oComment;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oPrecontract     = new Precontract;
        $this->oComment         = new Comment;
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $precontract  = Precontract::findOrfail($request->id);
        $comments = $precontract->comments()->with('user')->orderBy('commentdate', 'DESC')->get();

            if($request->ajax()){
                return $comments;
            }
        // return view('module_configuration.projectuses.index', compact('comments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $precontract  = Precontract::findOrfail($request->id);
        $result = $this->oComment->insertC($precontract,$request->all());
       
        return $result;

    }
}
