<?php

namespace Modules\Owner\Repositories\OwnerPass;

use App\Models\Owner;
use App\Models\OwnerPass;
use Illuminate\Support\Facades\Hash;
use Modules\Owner\Repositories\RepositoryAbstract;

class OwnerPassRepository extends RepositoryAbstract implements OwnerPassRepositoryInterface
{
    public function __construct(OwnerPass $ownerPass)
    {
        $this->model = $ownerPass;
    }

    public function getOwner($request)
    {
        $owner = $this->model->leftJoin('tbl_owner', 'tbl_owner.owner_cd', 'tbl_owner_pass.member_cd')
            ->where([
                'mail_add' => $request['id'],
                'certification_result' => Owner::CERTIFICATION_ACTIVE,
                'del_flg' => Owner::NOT_DELETED,
            ])->first();

        if ($owner && Hash::check($request['password'], $owner->pass)) {
            return $owner;
        }
    }
}
