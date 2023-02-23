<?php

namespace App\Models\Contracts;

use Auth;
use Illuminate\Database\Eloquent\Model;

class CommentTag extends Model
{
    public $timestamps = false;

    protected $table      = 'comment_tag';
    protected $primaryKey = 'commentTagId';
    protected $fillable   = ['commentTagId','companyId', 'commentTagName'];

//--------------------------------------------------------------------
    /** Relations */
//--------------------------------------------------------------------

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
public function getAllByCompany($companyId) {  
               
    return $this->where('companyId', '=', $companyId)
               ->orderBy('commentTagId', 'ASC')
               ->get(); 
}

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
