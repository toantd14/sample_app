<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
    protected $table = 'login_tokens';
    protected $primaryKey = 'user_cd';

    protected $fillable = [
        'user_cd',
        'access_token',
        'refresh_token',
        'expired_token_time',
        'expired_refresh_token_time',
    ];

    public function scopeUserCd($query, $userCd)
    {
        return $query->where('user_cd', $userCd);
    }

    public function scopeRefreshToken($query, $refreshToken)
    {
        return $query->where('refresh_token', $refreshToken);
    }
}
