<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Controllers\ApiController;
use App\Content\Entities\Category;
use App\Content\Entities\Post;
use App\Content\Transformers\ContentListTransformer;
use App\Content\Transformers\FatwaListTransformer;
use Illuminate\Http\Request;

class ContentController extends ApiController
{
    public function items($slug_category)
    {
        try {
            $category = Category::where('slug', $slug_category)->firstOrFail();

            $content = Post::where('category_id', $category->id)->get();

            if ($category->id == 6) {
                return $this->response->collection($content, new FatwaListTransformer);
            } else {
                return $this->response->collection($content, new ContentListTransformer);
            }
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function item($slug_category, $slug)
    {
        try {
            $category = Category::where('slug', $slug_category)->firstOrFail();

            $content = Post::where('category_id', $category->id)->where('slug', $slug)->get();

            return $this->response->collection($content, new ContentListTransformer);
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }
}
