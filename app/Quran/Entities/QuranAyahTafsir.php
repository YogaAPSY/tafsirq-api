<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyah;
use App\Quran\Entities\QuranTranslator;
use Illuminate\Database\Eloquent\Model;

class QuranAyahTafsir extends Model
{
    protected $table = 'quran_ayah_tafsir';

    public function quranAyah()
    {
        return $this->belongsTo(QuranAyah::class, 'tr_ayah_id', 'ayah_id');
    }

    public function quranTranslator()
    {
        return $this->belongsTo(QuranTranslator::class, 'translator_id', 'translator_id');
    }
}
