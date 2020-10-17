<?php

namespace App\Hadits\Transformers;

use App\Hadits\Entities\HaditsItem;
use League\Fractal\TransformerAbstract;

class HaditsAllItemTransformer extends TransformerAbstract
{
    public function transform(HaditsItem $hadits)
    {
        return [
            'id' => $hadits->id,
            'desc' => $hadits->text_id,
            'number' => $hadits->number,
        ];
    }
}
