<?php
namespace App\Content\Transformers;

use App\Content\Entities\Post;
use League\Fractal\TransformerAbstract;

class ContentListTransformer extends TransformerAbstract
{
    public function transform(Post $content)
    {
        return [
            'id' => $content->id,
            'category' => $content->categories->name,
            'slug_category' => $content->categories->slug,
            'slug' => $content->slug,
            'title' => $content->title,
            'content' => $content->content,
        ];
    }
}
