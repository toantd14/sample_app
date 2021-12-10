<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Http\Requests\Auth\LoginRequest;
use Modules\Admin\Repositories\Admin\AdminRepositoryInterface;

class AuthController extends Controller
{
    protected $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin::auth.login');
    }

    public function doLogin(LoginRequest $request)
    {

        $admin = $this->adminRepository->getAdmin($request->all());

        if (isset($admin)) {
            Auth::guard('admin')->login($admin);

            return view('admin::admin.index');
        }

        return back()->withErrors(__('validation.login.error'))->withInput($request->all());
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        request()->session()->flush();

        return redirect()->route('get.admin.login');
    }
}
