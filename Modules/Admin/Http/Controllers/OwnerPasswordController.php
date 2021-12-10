<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\Http\Requests\Owner\ChangePasswordRequest;
use Modules\Admin\Repositories\Owner\AdminOwnerRepositoryInterface;
use Modules\Admin\Repositories\OwnerPass\AdminOwnerPassRepositoryInterface;

class OwnerPasswordController extends Controller
{

    protected $adminOwnerPassRepository;
    protected $adminOwnerRepository;

    public function __construct(
        AdminOwnerPassRepositoryInterface $adminOwnerPassRepository,
        AdminOwnerRepositoryInterface $adminOwnerRepository
    ) {
        $this->adminOwnerPassRepository = $adminOwnerPassRepository;
        $this->adminOwnerRepository = $adminOwnerRepository;
    }

    /**
     * @param $owner
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($owner)
    {
        $newOwner = $this->adminOwnerRepository->get($owner);

        if ($newOwner) {
            $dataForBlade = $this->getDataForBlade($owner);

            return view('admin::owners.create_password', $dataForBlade);
        } else {
            return redirect()->route('admin.index');
        }
    }

    /**
     * @param $ownerCd
     * @return array
     */
    public function getDataForBlade($ownerCd)
    {
        $ownerPass = $this->adminOwnerPassRepository->show($ownerCd);
        $updated = null;

        if($ownerPass) {
            $updated = Carbon::parse($ownerPass->updated_at)->format(config('constants.DATE.FORMAT_YEAR_FIRST'));
        }

        return [
            'ownerCD' => $ownerCd,
            'ownerPass' => $ownerPass,
            'updated' => $updated,
        ];
    }

    /**
     * @param $ownerCD
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($ownerCD)
    {
        $newOwner = $this->adminOwnerRepository->get($ownerCD);

        if ($newOwner) {
            $dataForBlade = $this->getDataForBlade($ownerCD);

            return view('admin::owners.update_password', $dataForBlade);
        } else {
            return redirect()->route('admin.index');
        }
    }

    /**
     * @param ChangePasswordRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateOrCreate(ChangePasswordRequest $request, $id)
    {
        $admin = Auth::guard('admin')->user();

        try {
            $ownerPassword = $this->adminOwnerPassRepository->show($id);
            if ($ownerPassword) {
                $checkPass = $this->adminOwnerPassRepository->show($id)->pass;

                if (Hash::check($request->password, $checkPass)) {

                    return response()->json([
                        "message" => __('message.ownpassword.new_password_same_current_password')
                    ], Response::HTTP_BAD_REQUEST);
                }

                $updatePass = $this->adminOwnerPassRepository->update($id, [
                    "pass" => $request->password,
                    'updater' => $admin->name_mei
                ]);
            } else {
                $data = [
                    'member_cd' => $id,
                    'pass' => $request->password,
                    'registered_person' => $admin->name_mei
                ];

                $updatePass = $this->adminOwnerPassRepository->store($data);
            }

            if (isset($updatePass)) {
                return response()->json([
                    "message" => __('message.ownpassword.your_password_has_been_update')
                ], Response::HTTP_OK);
            }

        } catch (\Exception $e) {
            return response()->json([
                "message" => __('message.ownpassword.error')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
