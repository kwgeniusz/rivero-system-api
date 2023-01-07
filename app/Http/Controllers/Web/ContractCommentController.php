<?php

namespace App\Http\Controllers\Web;

use Auth;
use App;
use App\Contract;
use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContractCommentController extends Controller
{
    private $oContract;
    private $oComment;

    public function __construct()
    {
        $this->middleware('auth');
        $this->oContract        = new Contract;
        $this->oComment         = new Comment;
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $contract  = Contract::findOrfail($request->id);

        $comments = $contract->comments()->orderBy('commentdate', 'DESC')
                                         ->get(); 
        //  dd($comments);
        //  exit();

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
        $contract  = Contract::findOrfail($request->contractId);

        $result = $this->oComment->insertC($contract,$request->all());
       
        return $result;
         
        // $contract->comments()->create([
        //     'commentContent' => $request->commentContent,
        //     'commentDate'    => date('Y-m-d H:i:s'),
        //     'userId'         => Auth::user()->userId
        // ]);

    }
}
