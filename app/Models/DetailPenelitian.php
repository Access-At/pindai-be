<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenelitian extends Model
{
    use SoftDeletes;

    protected $table = 'detail_penelitian';

    protected $dates = ['deleted_at'];
}
