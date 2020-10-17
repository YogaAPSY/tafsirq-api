<?php

namespace App\Hadits\Transformers;

use App\Hadits\Entities\HaditsBook;
use League\Fractal\TransformerAbstract;

class HaditsBookTransformer extends TransformerAbstract
{
    public function transform(HaditsBook $hadits)
    {
        return [
            'id' => $hadits->id,
            'name' => $hadits->name,
            'total' => $hadits->hadits_items_count ?? 0,
            'slug' => $hadits->slug,
        ];
    }
}
