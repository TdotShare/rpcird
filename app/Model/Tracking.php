<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'rpcnew_tracking';
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
