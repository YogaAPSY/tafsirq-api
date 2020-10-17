<?php

namespace App\Content\Entities;

use App\Content\Entities\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $connection = 'mysql2';

    protected $table = 'cms_posts';

    protected $casts = [
        'meta' => 'json',
    ];

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
