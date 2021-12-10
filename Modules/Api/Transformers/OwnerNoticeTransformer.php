<?php

namespace Modules\Api\Transformers;

use App\Models\OwnerNotice;
use League\Fractal\TransformerAbstract;
use Modules\Api\Traits\ConvertTimeTraits;
use Modules\Owner\Repositories\OwnerNotice\OwnerNoticeRepositoryInterface;

class OwnerNoticeTransformer extends TransformerAbstract
{
    use ConvertTimeTraits;

    public function transform(OwnerNotice $ownerNotice)
    {
        return [
            'noticeID' => $ownerNotice->notics_cd,
            'noticeTitle' => $ownerNotice->notics_title,
            'createdAt' => ($ownerNotice->created_at)->format('Y-m-d\TH:m:sP')
        ];
    }
}
