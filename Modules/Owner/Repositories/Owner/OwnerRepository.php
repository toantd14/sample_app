<?php

namespace Modules\Owner\Repositories\Owner;

use App\Models\Owner;
use Facade\FlareClient\Flare;
use Modules\Owner\Repositories\RepositoryAbstract;

class OwnerRepository extends RepositoryAbstract implements OwnerRepositoryInterface
{
    public function __construct(Owner $owner)
    {
        $this->model = $owner;
    }

    public function getByOwnerCdAndCertificationCd($ownerCd, $certificationCd)
    {
        return $this->model->ownerCd($ownerCd)->certificationCd($certificationCd)->first();
    }

    public function updateCertificationResult($ownerCd, $certificationCd, $certificationResult)
    {
        $data = [
            'certification_result' => $certificationResult
        ];

        return $this->model->certificationCd($certificationCd)
            ->update($data);
    }

    public function getByOwnerCd($ownerCd)
    {
        return $this->model->ownerCd($ownerCd)->first();
    }

    public function checkCertificationAndDelFfg($email)
    {
        return !$this->model->mailAddress($email)->where('certification_result', 1)->exists();
    }

    public function checkEmailExits($email, $ownerId)
    {
        $member = $this->model->where([
            'mail_add' => $email,
            'certification_result' => Owner::CERTIFICATION_ACTIVE,
        ])->first();

        if (!$member || $member->owner_cd == $ownerId) {
            return false;
        }

        return true;
    }

    public function searchOwner($params)
    {
        return $this->model->with('prefecture')
            ->isCertificationActive()
            ->when(isset($params['mgn_flg']) && $params['mgn_flg'] >= 0, function ($query) use ($params) {
                $query->where('mgn_flg', $params["mgn_flg"]);
            })
            ->when(isset($params['user_kbn']) && $params['user_kbn'] >= 0, function ($query) use ($params) {
                $query->where('kubun', $params["user_kbn"]);
            })
            ->when(!empty($params['name_c']), function ($query) use ($params) {
                $query->where('name_c', 'LIKE', '%' . $params["name_c"] . '%');
            })
            ->when(!empty($params['prefectures_cd']), function ($query) use ($params) {
                $query->where('prefectures_cd', $params["prefectures_cd"]);
            })
            ->when(!empty($params['municipality_name']), function ($query) use ($params) {
                return $query->whereHas('prefecture', function ($query) use ($params) {
                    return $query->where('municipality_name', 'LIKE', '%' . $params["municipality_name"] . '%')
                        ->orWhere('townname_address', 'LIKE', '%' . $params["municipality_name"] . '%');
                });
            })
            ->when(!empty($params['tel_no']), function ($query) use ($params) {
                $query->where('tel_no', 'LIKE', '%' . $params["tel_no"] . '%');
            })
            ->when(!empty($params['mail_add']), function ($query) use ($params) {
                $query->where('mail_add', 'LIKE', '%' . $params["mail_add"] . '%');
            })
            ->latest()->paginate(config('constants.LIMIT_TABLE_ADMIN'));
    }
}
