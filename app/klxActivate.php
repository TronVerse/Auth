<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class klxActivate extends Model
{
    protected $table = 'klxActivate';

    protected $fillable = ['register', 'UUID', 'useable', 'usetime', 'activetime', 'creator'];
}
