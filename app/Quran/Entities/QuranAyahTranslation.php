<?php

namespace App\Quran\Entities;


use App\Quran\Entities\QuranAyah;
use App\Quran\Entities\QuranSurahTranslation;
use Illuminate\Database\Eloquent\Model;

class QuranAyahTranslation extends Model
{
    protected $table = 'quran_ayah_translation';

    public function quranAyah()
    {
        return $this->belongsTo(QuranAyah::class, 'qat_ayah_id');
    }

    public function quranSurahTranslation()
    {
        return $this->hasMany(QuranSurahTranslation::class, 'qst_surah_id', 'qat_surah_id');
    }
}
