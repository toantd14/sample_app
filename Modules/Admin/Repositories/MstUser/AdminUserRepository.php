<?php

namespace Modules\Admin\Repositories\MstUser;

use App\Models\MstUser;
use Modules\Owner\Repositories\RepositoryAbstract;

class AdminUserRepository extends RepositoryAbstract implements AdminUserRepositoryInterface
{

    public function __construct(MstUser $mstUser)
    {
        $this->model = $mstUser;
    }

    public function getByUserCdAndCertificationCd($userCd, $certificationCd)
    {
        return $this->model->userCd($userCd)->certificationCd($certificationCd)->first();
    }

    public function searchUser($params)
    {
        return $this->model->with('prefecture')
            ->when(isset($params['howto_use']) && $params['howto_use'] >= 0, function ($query) use ($params) {
                $query->where('howto_use', $params["howto_use"]);
            })
            ->when(isset($params['user_kbn']) && $params['user_kbn'] >= 0, function ($query) use ($params) {
                $query->where('user_kbn', $params["user_kbn"]);
            })
            ->when(!empty($params['corporate_name']), function ($query) use ($params) {
                $query->where('corporate_name', 'LIKE', '%' . $params["corporate_name"] . '%')
                    ->where('name_sei', 'LIKE', '%' . $params["corporate_name"] . '%')
                    ->where('name_mei', 'LIKE', '%' . $params["corporate_name"] . '%');
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
            ->paginate(config('constants.LIMIT_TABLE_ADMIN'));
    }

    public function checkCertificationAndDelFfg($email)
    {
        return !$this->model->mailAddress($email)->where('certification_result', 1)->exists();
    }

    public function checkEmailExits($email, $userCd)
    {
        $member = $this->model->where([
            'mail_add' => $email,
            'certification_result' => MstUser::CERTIFICATION_ACTIVE,
        ])->first();

        if (!$member || $member->user_cd == $userCd) {
            return false;
        }

        return true;
    }
}
