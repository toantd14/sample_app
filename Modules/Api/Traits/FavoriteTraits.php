<?php

namespace Modules\Api\Traits;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

trait FavoriteTraits
{
    public function checkFavorite($parkingLot)
    {
        if (!(Auth::guard('api')->user())) {
            return false;
        }
        $userCd = Auth::guard('api')->user()->user_cd;
        $parkingCd = $parkingLot->parking_cd;

        return $parkingLot->whereHas('favorites', function ($query) use ($userCd, $parkingCd) {
            $query->where([
                ['user_cd', $userCd],
                ['parking_cd', $parkingCd],
                ['del_flg', Favorite::NOT_DELETED]
            ]);
        })->exists();
    }
}
