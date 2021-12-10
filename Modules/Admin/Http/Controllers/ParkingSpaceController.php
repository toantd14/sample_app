<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Admin\Http\Requests\Parking\ParkingSpaceRequest;
use Modules\Admin\Repositories\ParkingSpace\AdminParkingSpaceRepositoryInterface;

class ParkingSpaceController extends Controller
{
    protected $adminparkingSpaceRepository;

    public function __construct(AdminParkingSpaceRepositoryInterface $adminparkingSpaceRepository)
    {
        $this->adminparkingSpaceRepository = $adminparkingSpaceRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * @param ParkingSpaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ParkingSpaceRequest $request)
    {
        //fake childNumber để lưu data
        $childNumber = 1;
        $dataSlot = $this->dataSlot($request->all());
        $dataSlot['child_number'] = $childNumber;
        $dataSlot['parking_cd'] = $request['parking_cd'];
        $checkSpaceNo = $this->checkSpaceNo($request->all());

        if (!$checkSpaceNo) {
            return redirect()->back()->withInput($request->input())->with('parkingSpaceExist', __('message.slot_parking.message_exist_parking_space'));
        }

        try {
            DB::beginTransaction();
            for ($i = $request->space_no_from; $i <= $request->space_no_to; $i++) {
                $dataSlot['space_no'] = $i;

                $this->adminparkingSpaceRepository->store($dataSlot);
            }
            DB::commit();

            return redirect()->back()->with('success', __('message.slot_parking.success'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->with('error', __('message.error'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $slotParking = $this->adminparkingSpaceRepository->show($id);
        $spaceNo = $this->adminparkingSpaceRepository->getSpaceNo($slotParking->space_no);

        return view('admin::parking_space.form-edit', compact('slotParking', 'spaceNo'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ParkingSpaceRequest $request, $id)
    {
        $dataSlot = $this->dataSlot($request->all());
        $checkSpaceNo = $this->checkSpaceNo($request->all());

        if (!$checkSpaceNo) {
            return response()->json([
                'error' => __('message.slot_parking.message_exist_parking_space'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->adminparkingSpaceRepository->update($id, $dataSlot);

        return response()->json([
            'success' => __('message.slot_parking.update_success'),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->adminparkingSpaceRepository->destroy($id);

        return redirect()->back();
    }

    public function dataSlot($request)
    {
        return [
            'parking_form' => $request['parking_form'],
            'kbn_standard' => $request['car_type']['kbn_standard'] ?? 0,
            'kbn_3no' => $request['car_type']['kbn_3no'] ?? 0,
            'kbn_lightcar' => $request['car_type']['kbn_lightcar'] ?? 0,
            'car_width' => $request['car_width'],
            'car_length' => $request['car_length'],
            'car_height' => $request['car_height'],
            'car_weight' => $request['car_weight'],
            'space_symbol' => $request['space_symbol'],
            'space_no' => $this->adminparkingSpaceRepository->handleSpaceForm($request['space_no_from'], $request['space_no_to'] ?? null)
        ];
    }

    public function checkSpaceNo($dataRequest)
    {
        $spaceParkings = $this->adminparkingSpaceRepository->getSpacesExceptSpaceNo($dataRequest['parking_cd'], $dataRequest['serial_no'] ?? null);
        foreach ($spaceParkings as $item) {
            if(isset($dataRequest['space_no_to'])) {
                if ($dataRequest['space_no_from'] <= $item->space_no && $dataRequest['space_no_to'] >= $item->space_no && $dataRequest['space_symbol'] == $item->space_symbol) {
                    return false;
                }
            } else {
                if ($dataRequest['space_no_from'] == $item->space_no && $dataRequest['space_symbol'] == $item->space_symbol) {
                    return false;
                }
            }
        }

        return true;
    }
}
