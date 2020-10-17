<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Controllers\ApiController;
use App\Hadits\Entities\HaditsBook;
use App\Hadits\Entities\HaditsItem;
use App\Hadits\Transformers\HaditsAllItemTransformer;
use App\Hadits\Transformers\HaditsBookTransformer;
use App\Hadits\Transformers\HaditsItemDetailTransformer;
use App\Hadits\Transformers\HaditsItemTransformer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

class HaditsController extends ApiController
{
    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function index()
    {
        try {
            $haditsBooks = HaditsBook::withCount('haditsItems')->get();

            return $this->response->collection($haditsBooks, new HaditsBookTransformer);
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function show($slug)
    {
        try {
            $haditsBook = HaditsBook::where('slug', $slug)->firstOrFail();

            $haditsItems = HaditsItem::select('id', 'number', 'text_arabic', 'text_id')
                                    ->where('book_id', $haditsBook->id)
                                    ->paginate(config('tafsirq.limit_per_page'));

            $haditsBookMeta = $this->manager->createData(new Item($haditsBook, new HaditsBookTransformer))->toArray();

            return $this->response->paginator($haditsItems, new HaditsItemTransformer)
                ->addMeta('book', collect($haditsBookMeta)->first());
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound($e->getMessage());
        } catch (\Exception $e) {
            return $this->response->errorBadRequest($e->getMessage());
        }
    }

    public function items($slug)
    {
        try {
            $expiresAt = Carbon::now()->addMonth(1);

            $haditsBook = HaditsBook::where('slug', $slug)->firstOrFail();

            $haditsItems = Cache::remember('hadits_' . $slug, $expiresAt, function () use ($haditsBook) {

                return HaditsItem::select('id', 'text_id', 'number')
                                    ->where('book_id', $haditsBook->id)
                                    ->where('language', 'id')->get();
            });
            return $this->response->collection($haditsItems, new HaditsAllItemTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound($e->getMessage());
        } catch (\Exception $e) {
            return $this->response->errorBadRequest($e->getMessage());
        }
    }

    public function item($slug, $id)
    {
        try {
            $haditsBook = HaditsBook::where('slug', $slug)->firstOrFail();

            $haditsItem = HaditsItem::where('book_id', $haditsBook->id)->where('id', $id)->firstOrFail();

            $haditsBookMeta = $this->manager->createData(new Item($haditsBook, new HaditsBookTransformer))->toArray();

            return $this->response->item($haditsItem, new HaditsItemTransformer)
                ->addMeta('book', collect($haditsBookMeta)->first());
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound($e->getMessage());
        } catch (\Exception $e) {
            return $this->response->errorBadRequest($e->getMessage());
        }
    }
}
