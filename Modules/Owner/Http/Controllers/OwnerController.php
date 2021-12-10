<?php

namespace Modules\Owner\Http\Controllers;

use App\Models\Owner;
use App\Traits\ImageTraits;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Modules\Owner\Http\Requests\Owner\OwnerRequest;
use Modules\Owner\Repositories\Owner\OwnerRepositoryInterface;
use Modules\Owner\Repositories\Prefecture\PrefectureRepositoryInterface;

class OwnerController extends Controller
{
    protected $ownerRepository;
    protected $prefectureRepository;
    use ImageTraits;

    public function __construct(
        OwnerRepositoryInterface $ownerRepository,
        PrefectureRepositoryInterface $prefectureRepository
    )
    {
        $this->ownerRepository = $ownerRepository;
        $this->prefectureRepository = $prefectureRepository;
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
        $owner = Auth::guard('owner')->user();
        $prefecture = $this->prefectureRepository->get($owner->prefectures_cd);

        if ($owner->owner_cd == $id) {
            return view('owner::member.edit', compact('owner', 'prefecture'));
        }

        return redirect()->route('top.index');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(OwnerRequest $request, $ownerId)
    {
        $checkEmailExits = $this->ownerRepository->checkEmailExits($request->mail_add, $ownerId);

        if ($checkEmailExits) {
            return redirect()->back()->with('emailExits', __('message.register.email_address_already_exists'));
        }

        $dataUpdate = $this->dataUpdate($request->all());
        $dataUpdate['stamp'] = $request->hasFile('stamp') ? $this->getBlobImage($request->stamp) : null;

        if(!$dataUpdate['prefectures_cd']) {
            return redirect()->back()->with('editErrors', trans('message.prefecture_not_found'));
        }

        try {
            $this->ownerRepository->update($ownerId, $dataUpdate);

            return redirect()->back()->with('success', trans('message.owner.update_success'));
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return redirect()->back()->with('editErrors', __('message.owner.error'));
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

    protected function dataUpdate($requestData)
    {
        return  [
            "kubun" => $requestData['kubun'],
            "name_c" => $requestData['name_c'],
            "person_man" => $requestData['person_man'],
            "department" => $requestData['department'],
            "hp_url" => $requestData['hp_url'],
            "mail_add" => $requestData['mail_add'],
            "zip_cd" => $requestData['zip_cd'],
            "prefectures" => $requestData['prefectures'],
            "municipality_name" => $requestData['municipality_name'],
            "townname_address" => $requestData['townname_address'],
            "building_name" => $requestData['building_name'],
            "prefectures_cd" => $this->prefectureRepository->getByName($requestData['prefectures'])->prefectures_cd ?? '',
            "tel_no" => $requestData['tel_no'],
            "fax_no" => $requestData['fax_no'],
            "registered_person" => $requestData['registered_person'] ?? null,
            "updater" => Auth::guard('owner')->user()->name_c
        ];
    }
}
