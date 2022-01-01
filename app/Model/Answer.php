<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'rpcnew_answer';
    protected $primaryKey = 'id';

    //public $incrementing = false;
    
    protected $fillable = [
        'id', 'topic_id', 'email' , 'user_by', 'content', 'file', 'create_at', 'update_at'
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
    
}
