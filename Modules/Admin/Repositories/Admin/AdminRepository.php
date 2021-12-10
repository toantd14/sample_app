<?php

namespace Modules\Admin\Repositories\Admin;

use App\Models\MstAdmin;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Repositories\RepositoryAbstract;

class AdminRepository extends RepositoryAbstract implements AdminRepositoryInterface
{
    public function __construct(MstAdmin $admin)
    {
        $this->model = $admin;
    }

    public function getAdmin($request)
    {
        $admin = $this->model->where('login_mail', $request['id'])->first();

        if ($admin && Hash::check($request['password'], $admin->passw)) {
            return $admin;
        }
    }
}
