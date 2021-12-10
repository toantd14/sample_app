<?php

namespace Modules\Owner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Owner\Http\Exports\TimeUsedExport;
use Modules\Owner\Http\Requests\UseSituation\UseSituationRequest;
use Modules\Owner\Repositories\UseSituation\UseSituationRepositoryInterface;

class UseSituationController extends Controller
{
    protected $useSituationRepository;

    public function __construct(UseSituationRepositoryInterface $useSituationRepository)
    {
        $this->useSituationRepository = $useSituationRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;
        $useSituations = $this->useSituationRepository->getAll($ownerCd);

        return view('owner::time_used.index', compact('useSituations', 'ownerCd'));
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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($receiptNumber)
    {
        $useSituation = $this->useSituationRepository->find($receiptNumber);
        $ownerCd = Auth::guard('owner')->user()->owner_cd;

        return view('owner::time_used.detail', compact('useSituation', 'ownerCd'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(UseSituationRequest $request)
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;
        $dataSearch = $this->dataSearch($request);
        $useSituations = $this->useSituationRepository->search($dataSearch)->latest('receipt_number')->paginate(config('constants.USE_SITUATION_PAGE_LIMIT'));

        return view('owner::time_used.index', compact('useSituations', 'ownerCd'));
    }

    public function exportCSV(Request $request)
    {
        $fileName = __('message.time_used.file_name');
        return Excel::download((new TimeUsedExport($this->useSituationRepository, $this->dataSearch($request))), $fileName);
    }

    public function dataSearch($request)
    {
        return [
            "year" => $request->input('year'),
            "month" => $request->input('month'),
            "use_day_from" => $request->input('use_day_from'),
            "use_day_to" => $request->input('use_day_to'),
            "parking_lot" => $request->input('parking_lot'),
            "reservation_day_from" => $request->input('reservation_day_from'),
            "reservation_day_to" => $request->input('reservation_day_to'),
            "visit_no" => $request->input('visit_no'),
            "reservation_use_kbn" => $request->input('reservation_use_kbn'),
            "payment_division" => $request->input('payment_division'),
            "payment_day_from" => $request->input('payment_day_from'),
            "payment_day_to" => $request->input('payment_day_to')
        ];
    }
}
