<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userAuthority extends Model
{
    protected $table = 'userAuthority';

    protected $fillable = ['userid', 'klxAmount', 'mhAmount'];
}
