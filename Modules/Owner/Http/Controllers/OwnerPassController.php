<?php

namespace Modules\Owner\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Owner\Http\Requests\Owner\ChangePasswordRequest;
use Modules\Owner\Repositories\OwnerPass\OwnerPassRepositoryInterface;

class OwnerPassController extends Controller
{
    protected $ownerPassRepository;

    public function __construct(
        OwnerPassRepositoryInterface $ownerPassRepository
    ) {
        $this->ownerPassRepository = $ownerPassRepository;
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $ownerPass = $this->ownerPassRepository->show($id);
        $updated = Carbon::parse($ownerPass->updated_at)->format(config('constants.DATE.FORMAT_YEAR_FIRST'));

        return view('owner::member.reset_password', compact('ownerPass', 'updated'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(ChangePasswordRequest $request, $id)
    {
        $checkPass = $this->ownerPassRepository->show($id)->pass;

        if (Hash::check($request->password, $checkPass)) {
            return back()->with('error', __('message.ownpassword.new_password_same_current_password'));
        }

        $updatePass = $this->ownerPassRepository->update($id, [
            "pass" => $request->password
        ]);

        if (isset($updatePass)) {
            return redirect()->back()->with('success', __('message.ownpassword.your_password_has_been_update'));
        }

        return back()->with('error', __('validation.login.error'));
    }
}
