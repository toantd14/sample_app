<?php

namespace App\Models;

use App\Scopes\DelFlgScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Model;

class Owner extends Model
{
    use SoftDeletes;

    const NOT_DELETED = 0;
    const DELETED = 1;
    const CERTIFICATION_ACTIVE = 1;
    const CERTIFICATION_NOT_ACTIVE = 0;

    const MGN_FLG_ALL = -1;
    const MGN_FLG_DISABLE = 0;
    const MGN_FLG_ENABLE = 1;

    const KUBUN_ALL = -1;
    const KUBUN_PERSONAL = 0;
    const KUBUN_CORPORATION = 1;

    protected static function booted()
    {
        static::addGlobalScope(new DelFlgScope);
    }

    protected $table = 'tbl_owner';
    protected $primaryKey = 'owner_cd';
    public $incrementing = false;

    protected $fillable = [
        'owner_cd',
        'kubun',
        'name_c',
        'person_man',
        'department',
        'hp_url',
        'mail_add',
        'zip_cd',
        'prefectures_cd',
        'municipality_name',
        'townname_address',
        'building_name',
        'tel_no',
        'fax_no',
        'certification_cd',
        'certification_result',
        'del_flg',
        'registered_person',
        'updater',
        'mgn_flg',
        'stamp'
    ];

    const NOT_AUTHENTICATED = 0;
    const AUTHENTICATED = 1;

    const PERSONAL = 0;
    const CORPORATION = 1;

    public function ownerPass()
    {
        return $this->hasOne(OwnerPass::class, 'member_cd', 'owner_cd');
    }

    public function ownerBank()
    {
        return $this->hasOne(OwnerBank::class, 'owner_cd', 'owner_cd');
    }

    public function parkingLot()
    {
        return $this->hasOne(ParkingLot::class, 'owner_cd', 'owner_cd');
    }

    public function menuMaster()
    {
        return $this->hasOne(ParkingMenu::class, 'owner_cd', 'owner_cd');
    }

    public function useSituation()
    {
        return $this->hasOne(UseSituation::class, 'owner_cd', 'owner_cd');
    }

    public function ownerNotice()
    {
        return $this->hasMany(OwnerNotice::class, 'member_cd', 'owner_cd');
    }

    public function scopeMailAddress($query, $mailAddress)
    {
        return $query->where('mail_add', $mailAddress);
    }

    public function scopeCertificationCd($query, $certificationCd)
    {
        return $query->where('certification_cd', $certificationCd);
    }

    public function scopeOwnerCd($query, $ownerCd)
    {
        return $query->where('owner_cd', $ownerCd);
    }

    public function scopeIsCertificationActive($query)
    {
        return $query->where('certification_result', self::CERTIFICATION_ACTIVE);
    }

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class, 'prefectures_cd', 'prefectures_cd');
    }

    public function useSituations()
    {
        return $this->hasMany(UseSituation::class, 'owner_cd', 'owner_cd');
    }
}
