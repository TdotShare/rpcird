<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'rpcnew_topic';
    protected $primaryKey = 'id';

    //public $incrementing = false;
    
    protected $fillable = [
        'id', 'name', 'keyword', 'progress', 'status', 'code', 'content', 'file', 'email' , 'create_by'
    ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
    
}
