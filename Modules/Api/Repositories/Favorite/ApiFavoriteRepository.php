<?php

namespace Modules\Api\Repositories\Favorite;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Modules\Api\Repositories\RepositoryAbstract;

class ApiFavoriteRepository extends RepositoryAbstract implements ApiFavoriteRepositoryInterface
{
    protected $model;

    public function __construct(Favorite $model)
    {
        $this->model = $model;
    }

    public function updateFavorite($parkingID, $isFavorite)
    {
        $favoriteInfo = [
            'parking_cd' => $parkingID,
            'user_cd' => auth('api')->user()->user_cd,
        ];

        $this->model::updateOrCreate($favoriteInfo, ['del_flg' => (int)!$isFavorite]);

        return ['isFav' => (boolean)$isFavorite];
    }

    public function getListFavoriteOfUser()
    {
        $userCd = Auth::user()->user_cd;

        return $this->model->where('user_cd', $userCd)->where('del_flg', Favorite::NOT_DELETED)->get();
    }
}
