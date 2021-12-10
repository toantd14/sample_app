<?php

namespace Modules\Api\Repositories\Favorite;

use Modules\Api\Repositories\RepositoryInterface;

interface ApiFavoriteRepositoryInterface extends RepositoryInterface
{
    public function updateFavorite($parkingID, $isFavorite);

    public function getListFavoriteOfUser();
}
