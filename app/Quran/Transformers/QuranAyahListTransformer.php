<?php
namespace App\Quran\Transformers;

use App\Quran\Entities\QuranAyah;
use League\Fractal\TransformerAbstract;

class QuranAyahListTransformer extends TransformerAbstract
{
    public function transform(QuranAyah $quran)
    {
        return [
            'id' => $quran->id,
            'surah_id' => $quran->surah_id,
            'ayah_number' => $quran->ayah_id,
            'name' => $quran->quranSurah->quranSurahTranslation->name,
            'text_arab' => $quran->text,
            'translation' => $quran->quranAyahTranslation->translation,
        ];
    }
}
