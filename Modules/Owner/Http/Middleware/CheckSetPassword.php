<?php

namespace Modules\Owner\Http\Middleware;

use App\Models\Owner;
use Closure;
use Illuminate\Http\Request;
use Modules\Owner\Repositories\Owner\OwnerRepository;

class CheckSetPassword
{
    protected $ownerRepository;

    public function __construct(OwnerRepository $ownerRepository)
    {
        $this->ownerRepository = $ownerRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $owner = $this->ownerRepository->getByOwnerCd($request->owner_cd);

        if (isset($owner) && isset($owner->certification_cd) && ($owner->certification_result == Owner::AUTHENTICATED)) {
            return redirect()->route('get.owner.login');
        }

        return $next($request);
    }
}
