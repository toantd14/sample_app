<?php

namespace Modules\Owner\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Owner\Http\Requests\Parking\ParkingSpaceRequest;
use Modules\Owner\Repositories\ParkingSpace\ParkingSpaceRepositoryInterface;

class SlotParkingController extends Controller
{
    protected $parkingSpaceRepository;

    public function __construct(ParkingSpaceRepositoryInterface $parkingSpaceRepository)
    {
        $this->parkingSpaceRepository = $parkingSpaceRepository;
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

                $this->parkingSpaceRepository->store($dataSlot);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return redirect()->back()->with('error', __('message.response.http_internal_server_error'));
        }

        return redirect()->back()->with('success', __('message.slot_parking.success'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $slotParking = $this->parkingSpaceRepository->show($id);
        $spaceNo = $this->parkingSpaceRepository->getSpaceNo($slotParking->space_no);

        return view('owner::slotsParking.form-edit', compact('slotParking', 'spaceNo'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('owner::slotsParking.edit');
    }

    /**
     * @param ParkingSpaceRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ParkingSpaceRequest $request, $id)
    {
        $dataSlot = $this->dataSlot($request->all());
        $checkSpaceNo = $this->checkSpaceNo($request->all());

        if (!$checkSpaceNo) {
            return response()->json([
                'error' => __('message.slot_parking.message_exist_parking_space')
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->parkingSpaceRepository->update($id, $dataSlot);

        return response()->json([
            'success' => __('message.slot_parking.update_success'),
        ], Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->parkingSpaceRepository->destroy($id);

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
            'space_no' => $this->parkingSpaceRepository->handleSpaceForm($request['space_no_from'], $request['space_no_to'] ?? '')
        ];
    }

    public function checkSpaceNo($dataRequest)
    {
        $spaceParkings = $this->parkingSpaceRepository->getSpacesExceptSpaceNo($dataRequest['parking_cd'], $dataRequest['serial_no'] ?? null);
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
