<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyah;
use Illuminate\Database\Eloquent\Model;

class QuranJuz extends Model
{
    protected $table = 'quran_juz';

    public function quranAyah()
    {
        return $this->hasMany(QuranAyah::class);
    }
}
