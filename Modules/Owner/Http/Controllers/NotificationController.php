<?php

namespace Modules\Owner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\Owner\Repositories\Parking\ParkingLotRepositoryInterface;
use Modules\Owner\Http\Requests\Notification\StoreNotificationRequest;
use Modules\Owner\Http\Requests\Notification\SearchNotificationRequest;
use Modules\Owner\Repositories\OwnerNotice\OwnerNoticeRepositoryInterface;

class NotificationController extends Controller
{
    protected $ownerCd;
    protected $ownerNoticeRepository;
    protected $parkingLotRepository;

    public function __construct(
        OwnerNoticeRepositoryInterface $ownerNoticeRepository,
        ParkingLotRepositoryInterface $parkingLotRepository
    ) {
        $this->middleware(function ($request, $next) {
            $this->ownerCd = Auth::guard('owner')->user()->owner_cd;

            return $next($request);
        });

        $this->ownerNoticeRepository = $ownerNoticeRepository;
        $this->parkingLotRepository = $parkingLotRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ownerCd = $this->ownerCd;
        $ownerNotices = $this->ownerNoticeRepository->getNotifications(config('constants.USE_NOTICE_PAGE_LIMIT'));
        $parkings = $this->parkingLotRepository->getAll($ownerCd);

        return view('owner::notifications.list', compact('ownerCd', 'ownerNotices', 'parkings'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $ownerCd = $this->ownerCd;
        $parkings = $this->parkingLotRepository->getAll($ownerCd);

        return view('owner::notifications.create', compact('ownerCd', 'parkings'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreNotificationRequest $request)
    {
        $dataNotice = $this->dataNotice($request->all());
        $dataNotice['member_cd'] = Auth::guard('owner')->user()->owner_cd;
        $dataNotice['registered_person'] = Auth::guard('owner')->user()->name_c;
        try {
            $this->ownerNoticeRepository->store($dataNotice);

            return redirect()->back()->with('success', __('validation.notification.insert_success'));
        } catch (QueryException $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();;
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $ownerCd = $this->ownerCd;
        $notification = $this->ownerNoticeRepository->get($id);
        $parkings = $this->parkingLotRepository->getAll($ownerCd);

        return view('owner::notifications.edit', compact('ownerCd', 'notification', 'parkings'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(StoreNotificationRequest $request, $id)
    {
        $dataNotice = $this->dataNotice($request->all());
        $dataNotice['updater'] = Auth::guard('owner')->user()->name_c;
        try {
            $this->ownerNoticeRepository->update($id, $dataNotice);

            return redirect()->back()->with('success', __('validation.notification.update_success'));
        } catch (QueryException $e) {
            return redirect()->back()->withError($e->getMessage())->withInput();;
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->ownerNoticeRepository->destroy($id);

        return redirect()->back()->with('deleteSuccess', __('validation.notification.delete_success'));
    }

    public function searchNotice(SearchNotificationRequest $request)
    {
        $ownerCd = $this->ownerCd;
        $dataSearch = [
            'title' => $request->input('title'),
            'parking_cd' => $request->input('parking_cd'),
            'date_public_from' => $request->input('date_public_from'),
            'date_public_to' => $request->input('date_public_to'),
            'created_at' => $request->input('created_at'),
        ];
        $ownerNotices = $this->ownerNoticeRepository->searchNotifications($dataSearch);
        $parkings = $this->parkingLotRepository->getAll($ownerCd);

        return view('owner::notifications.list', compact('ownerCd', 'ownerNotices', 'parkings'));
    }

    public function dataNotice($request)
    {
        return [
            'parking_cd' => $request['parking_cd'],
            'created_at' => $request['created_at'],
            'announce_period' => $request['announce_period'],
            'notics_title' => $request['notics_title'],
            'notics_details' => $request['notics_details'],
        ];
    }
}
