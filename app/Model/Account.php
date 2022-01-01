<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'rpcnew_user';
    protected $primaryKey = 'id';

    //public $incrementing = false;
    
    // protected $fillable = [
    //     'name'
    // ];

    // protected $hidden = [
    //     'pass_member',
    // ];

    protected $keyType = 'int';
    public $timestamps = false;
    
}
