<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mhActivate extends Model
{
    protected $table = 'mhActivate';

    protected $fillable = ['register', 'UUID', 'useable', 'usetime', 'activetime', 'creator'];
}
