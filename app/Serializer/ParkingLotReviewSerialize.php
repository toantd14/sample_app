<?php

namespace App\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class ParkingLotReviewSerialize extends ArraySerializer
{
    public function collection($resourceKey, array $data)
    {
        return $data;
    }

    public function item($resourceKey, array $data)
    {
        return $data;
    }

    public function null()
    {
        return ['data' => []];
    }

    public function meta(array $meta)
    {
        return [];
    }
}

