<?php

namespace Modules\Admin\Repositories\OwnerPass;

use App\Models\OwnerPass;
use Illuminate\Support\Facades\Hash;
use Modules\Owner\Repositories\RepositoryAbstract;

class AdminOwnerPassRepository extends RepositoryAbstract implements AdminOwnerPassRepositoryInterface
{
    public function __construct(OwnerPass $ownerPass)
    {
        $this->model = $ownerPass;
    }

    public function getOwner($request)
    {
        $owner = $this->model->leftJoin('tbl_owner', 'tbl_owner.owner_cd', 'tbl_owner_pass.member_cd')
            ->where('mail_add', $request['id'])->first();

        if ($owner && Hash::check($request['password'], $owner->pass)) {
            return $owner;
        }
    }
}
