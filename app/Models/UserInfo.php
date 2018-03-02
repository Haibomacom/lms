<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class UserInfo extends User
{
    use Notifiable;

    protected $table = 'user_info';

    protected $fillable = [
        'openid', 'unionid', 'session', 'role', 'mobile', 'mobile_verify',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function borrow()
    {
        return $this->hasMany(BookBorrow::class, 'user_id', 'id');
    }

    public function favorite()
    {
        return $this->hasMany(BookFavorite::class, 'user_id', 'id');
    }

    public function search()
    {
        return $this->hasOne(BookSearch::class, 'user_id', 'id');
    }
}
