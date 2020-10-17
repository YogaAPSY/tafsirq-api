<?php
namespace App\Content\Transformers;

use App\Content\Entities\Post;
use League\Fractal\TransformerAbstract;

class FatwaListTransformer extends TransformerAbstract
{
    public function transform(Post $fatwa)
    {
        return [
            'id' => $fatwa->id,
            'category' => $fatwa->categories->name,
            'slug_category' => $fatwa->categories->slug,
            'slug' => $fatwa->slug,
            'meta' => $fatwa->meta,
            'title' => $fatwa->title
        ];
    }
}
