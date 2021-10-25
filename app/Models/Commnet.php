<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commnet extends Model
{
    use HasFactory;

    protected $fillable = ['comment', 'user_id','post_id'];

    /*
      user - Comment (1:N)  
    */

    public function user() {
        //Comment 입장에서 연결된 User를 찾을 때 
        //belongsTo 관계 메서드릴 통해서 
        //연결 시켜주면 된다
        return $this->belongsTo(User::class, 'user_id', 'id', 'users');
        /*
            SELECT * 
            FROM USERS
            WHERE id = this.user_id
        */
    }
}
