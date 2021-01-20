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

    public function show()
    {

    }

    public function edit()
    {

    }

    public function destroy()
    {

    }

}
