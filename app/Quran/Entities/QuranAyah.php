<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyahTafsir;
use App\Quran\Entities\QuranAyahTranslation;
use App\Quran\Entities\QuranJuz;
use App\Quran\Entities\QuranSurah;
use App\Quran\Entities\QuranTag;
use Illuminate\Database\Eloquent\Model;

class QuranAyah extends Model
{
    protected $table = 'quran_ayah';

    public function quranSurah()
    {
        return $this->belongsTo(QuranSurah::class, 'surah_id');
    }

    public function quranAyahTranslation()
    {
        return $this->hasOne(QuranAyahTranslation::class, 'qat_ayah_id');
    }

    public function quranTags()
    {
        return $this->belongsToMany(QuranTag::class, 'quran_tag_ayah', 't_ayah_id', 't_tag_id');
    }

    public function quranAyahTafsir()
    {
        return $this->hasMany(QuranAyahTafsir::class, 'tr_ayah_id', 'ayah_id');
    }

    public function quranJuz()
    {
        return $this->belongsTo(QuranJuz::class);
    }
}
