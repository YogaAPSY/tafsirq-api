<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyahTranslation;
use App\Quran\Entities\QuranSurah;
use Illuminate\Database\Eloquent\Model;

class QuranSurahTranslation extends Model
{
    protected $table = 'quran_surah_translation';

    public function quranSurah()
    {
        return $this->belongsTo(QuranSurah::class, 'qst_surah_id');
    }

    public function quranAyahTranslation()
    {
        return $this->belongsTo(QuranAyahTranslation::class, 'qst_surah_id', 'qat_surah_id');
    }
}
