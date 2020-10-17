<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyah;
use App\Quran\Entities\QuranSurahTranslation;
use Illuminate\Database\Eloquent\Model;

class QuranSurah extends Model
{
    protected $table = 'quran_surah';

    public function quranSurahTranslation()
    {
        return $this->hasOne(QuranSurahTranslation::class, 'qst_surah_id');
    }

    public function quranAyah()
    {
        return $this->hasMany(QuranAyah::class, 'surah_id');
    }
}
