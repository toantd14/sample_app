<?php

namespace Modules\Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ParkingLot;
use Modules\Api\Repositories\Parking\ApiParkingLotRepositoryInterface;

class ParkingLotTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['menu'];
    protected $apiParkingLotRepository;

    public function __construct(ApiParkingLotRepositoryInterface $apiParkingLotRepository)
    {
        $this->apiParkingLotRepository = $apiParkingLotRepository;
    }

    public function transform(ParkingLot $parkingLot)
    {
        return [
            'parkingID' => $parkingLot->parking_cd,
            'parkingName' => $parkingLot->parking_name,
            'lat' => doubleval($parkingLot->latitude),
            'lon' => doubleval($parkingLot->longitude),
            'is24Hour' => $this->is24Hour($parkingLot),
            'openTime' => $parkingLot->sales_start_time,
            'endTime' => $parkingLot->sales_end_time,
            'zipCode' => $parkingLot->zip_cd,
            'prefectures' => $parkingLot->prefecture->prefectures_name,
            'municipality' => $parkingLot->municipality_name,
            'town' => $parkingLot->townname_address,
            'building' => $parkingLot->building_name,
            'isFav' => $this->isFavorite($parkingLot),
            "mgnFlg" => intval($parkingLot->mgn_flg),
            'evaluation' => $this->getEvaluation($parkingLot),
            'reviewNumber' => $parkingLot->reviews->count(),
            'media' => $this->getMediaData($parkingLot),
            'warning' => $parkingLot->warn,
            'reEnter' => boolval($parkingLot->re_enter),
            'netPayoff' => boolval($parkingLot->net_payoff),
            'localPayoff' => boolval($parkingLot->local_payoff),
            "parkingSpace" => [
                "parkingForm" => array_values($this->getListParkingForms($parkingLot)),
                "kbnStandard" => $this->isKbn($parkingLot, 'kbn_standard'),
                "kbn3no" => $this->isKbn($parkingLot, 'kbn_3no'),
                "kbnLightcar" => $this->isKbn($parkingLot, 'kbn_lightcar'),
                "maxSpace" => $this->getSpace($parkingLot),
                "minSpace" => $this->getSpace($parkingLot, false),
            ],
        ];
    }

    public function includeMenu(ParkingLot $parkingLot)
    {
        if (!$parkingLot->parkingMenu) {
            return null;
        }

        return $this->item($parkingLot->parkingMenu, new ParkingMenuTransformer());
    }

    public function is24Hour(ParkingLot $parkingLot)
    {
        return $parkingLot->sales_division == \App\Models\ParkingLot::SALES_DIVISION_ENABLE;
    }

    public function isFavorite(ParkingLot $parkingLot)
    {
        if (auth('api')->user()) {
            $authUserID = auth('api')->user()->user_cd;

            return $parkingLot->favorites->contains(function ($value) use ($authUserID) {
                return ($value['user_cd'] == $authUserID) && ($value['del_flg'] == \App\Models\Favorite::NOT_DELETED);
            });
        }

        return false;
    }

    public function getEvaluation(ParkingLot $parkingLot)
    {
        return $this->apiParkingLotRepository->getReviewEvaluation($parkingLot->reviews);
    }

    public function getMediaData(ParkingLot $parkingLot)
    {
        $images = [];
        $videos = [];
        $thumbnail_video = json_decode($parkingLot->thumbnail_video, true);
        for ($i = 1; $i <= ParkingLot::VIDEO_IMAGE_NUMBER; $i++) {
            $imageInfix = 'image' . $i . '_url';
            $videoInfix = 'video' . $i . '_url';
            if ($parkingLot[$imageInfix]) $images[] = $parkingLot[$imageInfix];
            if ($parkingLot[$videoInfix]) {
                $videos[] = [
                    'image' => $thumbnail_video['thumbnail' . $i . '_url'],
                    'video' => $parkingLot[$videoInfix]
                ];
            }
        }

        return [
            'images' => $images,
            'videos' => $videos
        ];
    }

    public function getListParkingForms(ParkingLot $parkingLot)
    {
        return $parkingLot->parkingSpaces->pluck('parking_form')->unique()->sort()->toArray();
    }

    public function isKbn(ParkingLot $parkingLot, string $kbn)
    {
        return $parkingLot->parkingSpaces->pluck($kbn)->contains(\App\Models\ParkingLot::KBN_TRUE);
    }

    public function getSpace(ParkingLot $parkingLot, bool $isMax = true)
    {
        if ($parkingLot->parkingSpaces->count()) {
            $length = $isMax ? $parkingLot->parkingSpaces->max('car_length') : $parkingLot->parkingSpaces->min('car_length');
            $listLengths = $parkingLot->parkingSpaces->where('car_length', $length);
            $width = $isMax ? $listLengths->max('car_width') : $listLengths->min('car_width');
            $listWidths = $parkingLot->parkingSpaces->where('car_width', $width);
            $height = $isMax ? $listWidths->max('car_height') : $listWidths->min('car_height');

            return [$length, $width, $height];
        } else {
            return [];
        }

    }
}
