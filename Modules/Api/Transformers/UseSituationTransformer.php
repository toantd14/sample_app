<?php


namespace Modules\Api\Transformers;


use App\Models\UseSituation;
use League\Fractal\TransformerAbstract;

class UseSituationTransformer extends TransformerAbstract
{
    public function transform(UseSituation $useSituation)
    {
        return [
            'receiptNumber' => $useSituation->receipt_number,
        ];
    }
}
