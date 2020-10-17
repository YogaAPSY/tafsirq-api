<?php
namespace App\Quran\Transformers;

use App\Quran\Entities\QuranAyah;
use League\Fractal\TransformerAbstract;

class QuranAyahTransformer extends TransformerAbstract
{
    public function transform(QuranAyah $quran)
    {
        $quranTagLists = [];
        $tafsirs = [];
        foreach ($quran->quranTags as $tags) {
            $quranTagList = [
                'tag' => $tags->tag,
                'id' => $tags->id,
            ];
            $quranTagLists[] = $quranTagList;
        }

        foreach ($quran->quranAyahTafsir as $tafsir) {
            $tafsirs[] = [
                'id' => $tafsir->id,
                'name' => $tafsir->quranTranslator->name,
                'tafsir' => $tafsir->trans_text
            ];
        }
        return [
            'id' => $quran->id,
            'surah_id' => $quran->surah_id,
            'ayah_number' => $quran->ayah_id,
            'name' => $quran->quranSurah->quranSurahTranslation->name,
            'text_arab' => $quran->text,
            'translation' => $quran->quranAyahTranslation->translation,
            'tags' => $quranTagLists,
            'tafsirs' => $tafsirs,
        ];
    }
}
