<?php

namespace Modules\Api\Repositories\MstUser;

use App\Models\MstUser;
use Modules\Api\Repositories\RepositoryAbstract;

class MstUserRepository extends RepositoryAbstract implements MstUserRepositoryInterface
{
    protected $model;

    public function __construct(MstUser $model)
    {
        $this->model = $model;
    }

    public function findByFacebookId($facebookId)
    {
        return $this->model->facebookId($facebookId)->first();
    }

    public function generateNewUserID()
    {
        return $this->model->latest('user_cd')->first()->user_cd + 1;
    }

    public function findByLineId($lineId)
    {
        return $this->model->lineId($lineId)->first();
    }

    public function findByGoogleId($googleId)
    {
        return $this->model->googleId($googleId)->first();
    }

    public function findOrCreateUser($dataUser, $howtoUse)
    {
        if ($howtoUse == MstUser::FACEBOOK) {
            $user = $this->findByFacebookId($dataUser->id);
        } elseif ($howtoUse == MstUser::LINE) {
            $user = $this->findByLineId($dataUser->userId);
        } else {
            $user = $this->findByGoogleId($dataUser->sub);
        }

        if (!$user) {
            $dataCreate = [
                'user_cd' => $this->generateNewUserID(),
                'howto_use' => $howtoUse,
                'facebook_id' => $dataUser->id ?? '',
                'line_id' => $dataUser->userId ?? '',
                'google_id' => $dataUser->sub ?? '',
                'name_mei' => $dataUser->name ?? $dataUser->displayName,
                'mail_add' => $dataUser->email ?? '',
                'prefectures_cd' => 1,
                'municipality_name' => '',
                'townname_address' => ''
            ];

            return $this->model->create($dataCreate);
        }

        return $user;
    }
}
