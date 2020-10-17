<?php
namespace App\Quran\Transformers;

use App\Quran\Entities\QuranSurah;
use League\Fractal\TransformerAbstract;

class QuranJuzTransformer extends TransformerAbstract
{
    public function transform(QuranSurah $quran)
    {
        $quranAyahText = [];
        foreach ($quran->quranAyah as $ayah) {
            $quranAyahText[] = $ayah->text;
        }
        return [
            'surah' => $quran->quranSurahTranslation->name,
            'meaning' => $quran->quranSurahTranslation->meaning,
            'ayah_count' => $quran->ayah_count,
            'surah_id' => $quran->quranSurahTranslation->qst_surah_id,
            'type' => $quran->type,
            'text_arab' => $quranAyahText,
        ];
    }
}
