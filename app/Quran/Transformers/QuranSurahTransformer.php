<?php
namespace App\Quran\Transformers;

use App\Quran\Entities\QuranSurah;
use League\Fractal\TransformerAbstract;

class QuranSurahTransformer extends TransformerAbstract
{
    public function transform(QuranSurah $quran)
    {
        return [
            'id' => $quran->id,
            'name' => $quran->quranSurahTranslation->name,
            'text_arabic' => $quran->arabic,
            'meaning' => $quran->quranSurahTranslation->meaning,
            'type' => $quran->type,
            'total' => $quran->ayah_count,
        ];
    }
}
