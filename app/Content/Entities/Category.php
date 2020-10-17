<?php

namespace App\Content\Entities;

use App\Content\Entities\Post;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'cms_categories';

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
