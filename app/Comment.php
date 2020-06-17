<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    protected $table      = 'comment';
    protected $primaryKey = 'commentId';
    protected $fillable   = ['commentId','commentContent', 'commentDate', 'contractId','userId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
     public function user()
    {
        return $this->hasOne('App\User', 'userId', 'userId');
    }
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    public function getAllByContract($contractId)
    {
        return $this->with('user')
                    ->where('contractId', $contractId)
                    ->orderBy('commentDate', 'DESC')->get();
    }
//------------------------------------------
    public function insertC($request)
    {
        $comment                  = new Comment;
        $comment->commentContent  = $request->commentContent;
        $comment->commentDate     = date('Y-m-d H:i:s');
        $comment->contractId      = $request->contractId;
        $comment->userId          = Auth::user()->userId;
        $comment->save();

         if ($comment) {
            return $result = ['alert-type' => 'success', 'message' => 'Nuevo Comentario Insertado'];
        } else {
            return $result = ['alert-type' => 'error', 'message' => $error];
        }
    }
//------------------------------------------
//     public function updateC($projectUseId, $projectUseName)
//     {
//         $this->where('projectUseId', $projectUseId)->update(array(
//             'projectUseName' => $projectUseName,
//         ));
//     }
// //------------------------------------------
//     public function deleteC($projectUseId)
//     {
//         return $this->where('projectUseId', '=', $projectUseId)->delete();
//     }
//------------------------------------------
}
