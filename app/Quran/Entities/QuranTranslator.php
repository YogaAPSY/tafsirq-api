<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyahTafsir;
use Illuminate\Database\Eloquent\Model;

class QuranTranslator extends Model
{
    protected $table = 'quran_translator';

    public function quranAyahTafsir()
    {
        return $this->hasMany(QuranAyahTafsir::class, 'translator_id', 'translator_id');
    }
}
