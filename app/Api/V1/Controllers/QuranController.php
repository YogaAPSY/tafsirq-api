<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Quran\Entities\QuranAyah;
use App\Quran\Entities\QuranAyahTranslation;
use App\Quran\Entities\QuranJuz;
use App\Quran\Entities\QuranSurah;
use App\Quran\Entities\QuranSurahTranslation;
use App\Quran\Entities\QuranTag;
use App\Quran\Transformers\QuranAyahListTransformer;
use App\Quran\Transformers\QuranAyahTransformer;
use App\Quran\Transformers\QuranJuzTransformer;
use App\Quran\Transformers\QuranSurahTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class QuranController extends ApiController
{
    public function index()
    {
        try {
            $quranSurahList = QuranSurah::with(['quranSurahTranslation' => function ($query) {
                             $query->where('language', 'id');
            }])->get();
            return $this->response->collection($quranSurahList, new QuranSurahTransformer);
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $quranAyahList = QuranAyah::with(['quranAyahTranslation' => function ($query) {
                $query->where('language', 'id');
            }])->where('surah_id', $id)->paginate(config('tafsirq.limit_per_page'));

             return $this->response->paginator($quranAyahList, new QuranAyahListTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound($e->getMessage());
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function items($id)
    {
        try {
            $quranAyahAllList = QuranAyah::with(['quranAyahTranslation' => function ($query) {
                $query->where('language', 'id');
            }])->where('surah_id', $id)->get();

             return $this->response->collection($quranAyahAllList, new QuranAyahListTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound($e->getMessage());
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function item($surah_id, $ayah_id)
    {
        try {
            $quranAyah = QuranAyah::with(['quranAyahTranslation' => function ($query) {
                $query->where('language', 'id');
            }])->with(['quranAyahTafsir' => function ($query) use ($surah_id, $ayah_id) {
                $query->where('tr_surah_id', $surah_id);
                $query->where('tr_ayah_id', $ayah_id);
                $query->where('language', 'id');
            }])->with('quranTags')->where('surah_id', $surah_id)->where('ayah_id', $ayah_id)->firstOrFail();

            return $this->response->item($quranAyah, new QuranAyahTransformer);
        } catch (ModelNotFoundException $e) {
            return $this->response->errorNotFound($e->getMessage());
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function juz($id)
    {
        try {
            $quranAyah = QuranAyah::where('juz', $id)->first();
            $quranSurah = QuranSurah::with(['quranAyah' => function ($query) use ($quranAyah) {
                $query->where('juz', $quranAyah->juz);
                $query->where('page', $quranAyah->page);
            }])->with(['QuranSurahTranslation' => function ($query) {
                $query->where('language', 'id');
            }])->where('id', $quranAyah->surah_id)->first();

            return $this->response->item($quranSurah, new QuranJuzTransformer);
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function juzPage($page)
    {
        try {
            $quranAyah = QuranAyah::where('page', $page)->first();
            $quranSurah = QuranSurah::with(['quranAyah' => function ($query) use ($page) {
                $query->where('page', $page);
            }])->with(['QuranSurahTranslation' => function ($query) {
                $query->where('language', 'id');
            }])->where('id', $quranAyah->surah_id)->get();

            return $this->response->collection($quranSurah, new QuranJuzTransformer);
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }

    public function juzSurah($surah_id)
    {
        try {
            $quranAyah = QuranAyah::where('surah_id', $surah_id)->first();
            $quranSurah = QuranSurah::with(['quranAyah' => function ($query) use ($quranAyah) {
                $query->where('page', $quranAyah->page);
            }])->with(['QuranSurahTranslation' => function ($query) {
                $query->where('language', 'id');
            }])->where('id', $quranAyah->surah_id)->first();

            return $this->response->item($quranSurah, new QuranJuzTransformer);
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }
}
