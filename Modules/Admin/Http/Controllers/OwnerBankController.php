<?php

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\OwnerBank\OwnerBankRequest;
use Modules\Admin\Repositories\Owner\AdminOwnerRepositoryInterface;
use Modules\Admin\Repositories\OwnerBank\AdminOwnerBankRepositoryInterface;
use Modules\Owner\Repositories\OwnerBank\OwnerBankRepositoryInterface;

class OwnerBankController extends Controller
{
    protected $ownerBankRepository;
    protected $adminOwnerBankRepository;
    protected $adminOwnerRepository;

    public function __construct(OwnerBankRepositoryInterface $ownerBankRepository,
        AdminOwnerBankRepositoryInterface $adminOwnerBankRepository,
        AdminOwnerRepositoryInterface $adminOwnerRepository
    )
    {
        $this->ownerBankRepository = $ownerBankRepository;
        $this->adminOwnerBankRepository = $adminOwnerBankRepository;
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

            return view('admin::owner_bank.create_owner_bank', $dataForBlade);
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
        $ownerBank = $this->ownerBankRepository->getByOwnerCd($ownerCd);
        $updated = $created = null;
        if ($ownerBank) {
            $updated = Carbon::parse($ownerBank->updated_at)->format(config('constants.DATE.FORMAT_YEAR_FIRST'));
            $created = Carbon::parse($ownerBank->created_at)->format(config('constants.DATE.FORMAT_YEAR_FIRST'));
        }

        return [
            'ownerCD' => $ownerCd,
            'ownerBank' => $ownerBank,
            'updated' => $updated,
            'created' => $created
        ];
    }

    /**
     * @param $ownerCD
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editOrUpdate($ownerCD)
    {
        $newOwner = $this->adminOwnerRepository->get($ownerCD);

        if ($newOwner) {
            $dataForBlade = $this->getDataForBlade($ownerCD);

            return view('admin::owner_bank.edit_owner_bank', $dataForBlade);
        } else {
            return redirect()->route('admin.index');
        }
    }

    /**
     * @param OwnerBankRequest $request
     * @param $ownerCd
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateOrCreate(OwnerBankRequest $request, $ownerCd)
    {
        $admin = Auth::guard('admin')->user();

        $ownerBank = $this->adminOwnerBankRepository->getByOwnerCd($ownerCd);
        $dataOwnerBank = $this->dataUpdateOwnerBank($request);

        try {
            if (count($ownerBank)) {
                $dataOwnerBank['updater'] = $admin->name_mei;
                $this->adminOwnerBankRepository->update($ownerCd, $dataOwnerBank);

                return response()->json([
                    'message' => __('message.owner_bank.success')
                ], Response::HTTP_OK);
            } else {
                $dataOwnerBank['owner_cd'] = $ownerCd;
                $dataOwnerBank['registered_person'] = $admin->name_mei;

                $this->adminOwnerBankRepository->store($dataOwnerBank);
            }

            return response()->json([
                'message' => __('message.owner_bank.success')
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('message.owner_bank.error')
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function dataUpdateOwnerBank($request)
    {
        return  [
            'bank_cd' => $request['bank_cd'],
            'bank_name' => $request['bank_name'],
            'branch_cd' => $request['branch_cd'],
            'branch_name' => $request['branch_name'],
            'account_type' => $request['account_type'],
            'account_name' => $request['account_name'],
            'account_kana' => $request['account_kana'],
            'account_no' => $request['account_no'],
            'updated_at' => Carbon::now()->toDateString(),
        ];
    }
}
