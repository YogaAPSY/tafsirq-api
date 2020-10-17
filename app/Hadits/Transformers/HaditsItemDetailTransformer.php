<?php
namespace App\Hadits\Transformers;

use App\Hadits\Entities\HaditsItem;
use League\Fractal\TransformerAbstract;

class HaditsItemDetailTransformer extends TransformerAbstract
{
    public function transform(HaditsItem $hadits)
    {
        return [
            'id' => $hadits->id,
            'name' => $hadits->haditsBook->name,
            'text_arabic' => $hadits->text_arabic,
            'desc' => $hadits->text_id,
            'number' => $hadits->number,
        ];
    }
}
