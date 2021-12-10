<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Http\Exports\TimeUsedExport;
use Modules\Admin\Http\Requests\Situation\SearchRequest;
use Modules\Admin\Repositories\UseSituation\AdminUseSituationRepositoryInterface;

class UseSituationController extends Controller
{
    protected $adminUseSituationRepository;

    public function __construct(AdminUseSituationRepositoryInterface $adminUseSituationRepository)
    {
        $this->adminUseSituationRepository = $adminUseSituationRepository;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $useSituations = $this->adminUseSituationRepository->getAll();

        return view('admin::use_situations.index', compact('useSituations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('admin::create');
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
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $useSituation = $this->adminUseSituationRepository->get($id);

        return view('admin::use_situations.detail', compact('useSituation'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('admin::edit');
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

    public function search(SearchRequest $request)
    {
        $useSituations = $this->adminUseSituationRepository->search($request->except('_token'));

        return view('admin::use_situations.index', compact('useSituations'));
    }

    public function exportCSV(Request $request)
    {
        $fileName = __('message.time_used.file_name');
        return Excel::download((new TimeUsedExport($this->adminUseSituationRepository, $this->dataSearch($request))), $fileName);
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
