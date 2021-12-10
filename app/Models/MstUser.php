<?php

namespace App\Models;

use App\Scopes\DelFlgScope;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class MstUser extends Authenticatable implements JWTSubject
{
    use SoftDeletes, HasApiTokens;

    const CERTIFICATION_ACTIVE = 1;
    const CERTIFICATION_NOT_ACTIVE = 0;

    const USER_KUBUN_PERSONAL = 0;
    const USER_KUBUN_CORPORATION = 1;

    protected static function booted()
    {
        static::addGlobalScope(new DelFlgScope);
    }

    protected $table = 'mst_user';
    protected $primaryKey = 'user_cd';
    public $incrementing = false;
    protected $fillable = [
        'user_cd',
        'howto_use',
        'facebook_id',
        'google_id',
        'line_id',
        'user_kbn',
        'name_sei',
        'name_mei',
        'corporate_name',
        'department',
        'person_man',
        'tel_no',
        'mail_add',
        'pass_word',
        'zip_cd',
        'prefectures_cd',
        'municipality_name',
        'townname_address',
        'building_name',
        'token_key',
        'certification_cd',
        'certification_result',
        'registered_person',
        'updater'
    ];

    const ID_PASSWORD = 0;
    const FACEBOOK = 1;
    const GOOGLE = 2;
    const LINE = 3;
    const PERSONAL = 0;
    const COMPANY = 1;

    const TYPE_LOGIN = [
        0 => 'IDログイン',
        1 => 'Facebook',
        2 => 'Google',
        3 => 'Line'
    ];

    const CERTIFICATION_ENABLE = 1;

    public function getAuthPassword()
    {
        return $this->pass_word;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['pass_word'] = Hash::make($value);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_cd', 'user_cd');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_cd', 'user_cd');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function scopeFacebookId($query, $facebookId)
    {
        return $query->where('facebook_id', $facebookId);
    }

    public function scopeUserCd($query, $userCd)
    {
        return $query->where('user_cd', $userCd);
    }

    public function scopeLineId($query, $lineId)
    {
        return $query->where('line_id', $lineId);
    }

    public function scopeGoogleId($query, $googleId)
    {
        return $query->where('google_id', $googleId);
    }

    public function scopeCertificationCd($query, $certificationCd)
    {
        return $query->where('certification_cd', $certificationCd);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class, 'prefectures_cd', 'prefectures_cd');
    }

    public function scopeMailAddress($query, $mailAddress)
    {
        return $query->where('mail_add', $mailAddress);
    }

    public function uniqueUserID()
    {
        switch ($this->howto_use) {
            case MstUser::FACEBOOK:
                return $this->facebook_id;
                break;
            case MstUser::GOOGLE:
                return $this->google_id;
                break;
            case MstUser::LINE:
                return $this->line_id;
                break;
            default:
                return $this->mail_add;
        }
    }
}
