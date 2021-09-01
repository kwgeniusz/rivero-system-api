<?php

namespace App;

use Carbon\Carbon;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = false;

    protected $table      = 'comment';
    protected $primaryKey = 'commentId';
    protected $appends = ['commentDate'];
    protected $fillable   = ['commentId','commentContent', 'commentDate', 'contractId','userId'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------
    public function commentable()
    {
        return $this->morphTo();
    }
     public function user()
    {
        return $this->hasOne('App\User', 'userId', 'userId');
    }

    function PerTransaction() {
        return $this->hasOne(User::class, 'userId','userId');
    }

//--------------------------------------------------------------------
    /** Accesores  */
//--------------------------------------------------------------------
public function getCommentDateAttribute()
{
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['commentDate'], 'UTC');
    $date->tz = session('companyTimeZone');   // ... set to the current users timezone
    return $date->format('Y-m-d H:i:s');
}    
//--------------------------------------------------------------------
    /** Mutadores  */
//--------------------------------------------------------------------
public function setCommentDateAttribute($commentDate)
{  
    $date = Carbon::createFromFormat('Y-m-d', $commentDate, session('companyTimeZone'));
    $date->setTimezone('UTC');
    $this->attributes['commentDate'] = $date;
}    
//--------------------------------------------------------------------
    /** Function of Models */
//--------------------------------------------------------------------
    //------------------------------------------
//     public function findById($projectUseId, $projectUseName)
//     {
//         $this->where('projectUseId', $projectUseId)->update(array(
//             'projectUseName' => $projectUseName,
//         ));
//     }
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
//        $model=$modelType::findOrFail($request->modelId);

//        $model->comments()->detach($commentId);
//         return $this->where('projectUseId', '=', $projectUseId)->delete();
//     }
//------------------------------------------


   public function insertC($model,$data)
    {
        $comment                      = new Comment;
        $comment->commentContent      = $data['commentContent'];
        $comment->commentDate         = date('Y-m-d');
        $comment->commentable_id      = $model->getKey();
        $comment->commentable_type    = get_class($model);
        $comment->userId              = Auth::user()->userId;
        $comment->save();

         if ($comment) {
            return $result = ['alert-type' => 'success', 'message' => 'Nuevo Comentario Insertado'];
        } else {
            return $result = ['alert-type' => 'error', 'message' => $error];
        }
    }

}
