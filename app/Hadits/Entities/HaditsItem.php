<?php

namespace App\Hadits\Entities;

use App\Hadits\Entities\HaditsBook;
use Illuminate\Database\Eloquent\Model;

class HaditsItem extends Model
{
    protected $table = 'hadits_item';

    public function haditsBooks()
    {
        return $this->belongsTo(HaditsBook::class, 'book_id');
    }
}
