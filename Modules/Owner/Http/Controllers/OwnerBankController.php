<?php

namespace Modules\Owner\Http\Controllers;

use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Modules\Owner\Http\Requests\OwnerBank\OwnerBankRequest;
use Modules\Owner\Repositories\OwnerBank\OwnerBankRepositoryInterface;

class OwnerBankController extends Controller
{
    protected $ownerBankRepository;

    public function __construct(OwnerBankRepositoryInterface $ownerBankRepository)
    {
        $this->ownerBankRepository = $ownerBankRepository;
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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(OwnerBankRequest $request)
    {
        try {
            $dataOwnerBank = $this->dataOwnerBank($request);
            $dataOwnerBank['owner_cd'] = Auth::guard('owner')->user()->owner_cd;
            $dataOwnerBank['registered_person'] = Auth::guard('owner')->user()->person_man;
            $this->ownerBankRepository->store($dataOwnerBank);

            return redirect()->back()->with('success', __('message.owner_bank.success'));
        } catch (QueryException $e) {
            return redirect()->back()->with('error', __('message.owner_bank.error'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($ownerCd)
    {
        if($ownerCd != Auth::guard('owner')->user()->owner_cd){
            return back()->with('error', __('message.owner_bank.error'));
        }
        $ownerBank = $this->ownerBankRepository->get($ownerCd);

        if (!$ownerBank) {
            return view('owner::owner_bank.create', compact('ownerCd'));
        }

        return view('owner::owner_bank.edit', compact('ownerBank'));
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
    public function update(OwnerBankRequest $request, $ownerCd)
    {
        try {
            $dataOwnerBank = $this->dataOwnerBank($request);
            $this->ownerBankRepository->update($ownerCd, $dataOwnerBank);

            return redirect()->back()->with('success', __('message.owner_bank.success'));
        } catch (QueryException $e) {
            return redirect()->back()->with('error', __('message.owner_bank.error'));
        }
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

    public function dataOwnerBank($request)
    {
        return [
            'bank_cd' => $request['bank_cd'],
            'bank_name' => $request['bank_name'],
            'branch_cd' => $request['branch_cd'],
            'branch_name' => $request['branch_name'],
            'account_type' => $request['account_type'],
            'account_name' => $request['account_name'],
            'account_kana' => $request['account_kana'],
            'account_no' => $request['account_no'],
            'updater' => Auth::guard('owner')->user()->person_man
        ];
    }
}
