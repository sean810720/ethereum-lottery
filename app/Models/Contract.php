<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/*
 * 合約管理
 */

class Contract extends Model
{
    protected $table   = 'contract';
    protected $hidden  = ['id'];
    protected $guarded = ['id'];
}
