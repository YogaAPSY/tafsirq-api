<?php

namespace App\Quran\Entities;

use App\Quran\Entities\QuranAyah;
use Illuminate\Database\Eloquent\Model;

class QuranTag extends Model
{
    protected $table = 'quran_tag';

    public function quranAyahs()
    {
        return $this->belongsToMany(QuranAyah::class, 'quran_tag_ayah', 't_tag_id', 't_ayah_id');
    }
}
