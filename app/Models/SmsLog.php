<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = 'sms_log';

    public $incrementing = false;

    protected $fillable = [
        'mobile', 'code', 'status', 'result',
    ];

    protected $hidden = [];
}
