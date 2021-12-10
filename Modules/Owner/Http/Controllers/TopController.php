<?php

namespace Modules\Owner\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Owner\Repositories\AdminNotice\AdminNoticeRepositoryInterface;

class TopController extends Controller
{
    protected $adminNoticeRepository;

    public function __construct(AdminNoticeRepositoryInterface $adminNoticeRepository)
    {
        $this->adminNoticeRepository = $adminNoticeRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $ownerCd = Auth::guard('owner')->user()->owner_cd;
        $notifications = $this->adminNoticeRepository->getNotifications(config('constants.PAGE_LIMIT'));

        return view('owner::top.index', compact('notifications', 'ownerCd'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('owner::create');
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
    public function show($id)
    {
        return view('owner::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('owner::edit');
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
}
