<?php

namespace App\Hadits\Entities;

use App\Hadits\Entities\HaditsItem;
use Illuminate\Database\Eloquent\Model;

class HaditsBook extends Model
{
    protected $table = 'hadits_book';

    public function haditsItems()
    {
        return $this->hasMany(HaditsItem::class, 'book_id');
    }
}
