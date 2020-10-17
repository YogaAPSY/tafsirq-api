<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Controllers\ApiController;
use App\Content\Entities\Post;
use App\Hadits\Entities\HaditsItem;
use App\Quran\Entities\QuranAyah;
use App\Quran\Entities\QuranAyahTranslation;
use App\Quran\Entities\QuranSurah;
use App\Quran\Entities\QuranSurahTranslation;
use Illuminate\Support\Facades\DB;

class SearchController extends ApiController
{
    public function popularSearch()
    {
        $log_search = DB::table('log_search')->where('language', 'id')
        ->distinct('keyword')->orderBy('result_count', 'desc')
        ->orderBy('created_at', 'desc')->limit(5)->get();

        $popularSearch = [
            'data' => $log_search
        ];

        return $popularSearch;
    }

    public function search($keyword)
    {
        try {
            $keyword = explode(" ", $keyword);
            $commonword = ["yang", "dan", "al" ,"an", "An", "Al","Yang"];
            $searchquran = QuranAyahTranslation::Where(function ($query) use ($keyword, $commonword) {
                for ($i = 0; $i < count($keyword); $i ++) {
                    if (count($keyword) > 1) {
                        if (in_array($keyword[$i], $commonword) === false) {
                            $query->where('language', 'id');
                            $query->orWhere('translation', 'LIKE', '%' .$keyword[$i]. '%');
                            $query->orWhere('qat_ayah_id', '=', $keyword[$i]);
                        }
                    } else {
                        $query->orWhere('translation', 'LIKE', '%' .$keyword[$i]. '%');
                        $query->orWhere('qat_ayah_id', '=', $keyword[$i]);
                    }
                }
            })->with(['quranSurahTranslation' => function ($query) use ($keyword, $commonword) {
                for ($i = 0; $i < count($keyword); $i ++) {
                    if (count($keyword) > 1) {
                        if (in_array($keyword[$i], $commonword) === false) {
                            $query->where('language', 'id');
                            $query->orWhere('name', '=', $keyword[$i]);
                        }
                    } else {
                        $query->where('language', 'id');
                        $query->orWhere('name', '=', $keyword[$i]);
                    }
                }
            }])->get();

            $quran = [];
            foreach ($searchquran as $search) {
                $qurans = [
                    'id' => $search->quranAyah->id,
                    'surah_id' => $search->quranAyah->surah_id,
                    'ayah_number' => $search->quranAyah->ayah_id,
                    'name' => $search->quranAyah->quranSurah->quranSurahTranslation->name,
                    'translation' => $search->translation,
                ];
                $quran[] = $qurans;
            }

            $searchhadits = HaditsItem::orwhere(function ($query) use ($keyword) {
                //$query->orWhere('language', 'id');
                for ($i = 0; $i < count($keyword); $i ++) {
                    $query->orWhere('text_id', 'LIKE', '%'.$keyword[$i].'%');
                    $query->orWhere('number', '=', $keyword[$i]);
                }
            })->with(['haditsBooks' => function ($query) use ($keyword) {
                for ($i = 0; $i < count($keyword); $i ++) {
                    $query->orWhere('name', 'LIKE', '%'.$keyword[$i] .'%');
                }
                 return $query;
            }])->limit(config('tafsirq.limit_search_hadits'))->get();

            $hadits = [];
            foreach ($searchhadits as $search) {
                $hadit = [
                    'id' => $search->id,
                    'number' => $search->number,
                    'name' => $search->haditsBooks->name,
                    'slug' => $search->haditsBooks->slug,
                    'desc' => str_limit($search->text_id, config('tafsirq.limit_string')),
                ];
                $hadits[] = $hadit;
            }

            $searchkonten = Post::where(function ($query) use ($keyword) {
                for ($i = 0; $i < count($keyword); $i ++) {
                    $query->orWhere('title', 'LIKE', '%'.$keyword[$i].'%');
                }
            })->with('categories')->get();

            $doa = [];
            $ceritaHikmah = [];
            $doas = [];
            $ceritaHikmas = [];
            foreach ($searchkonten as $search) {
                if ($search->categories->slug == 'doa'|| $search->categories->slug == 'Doa') {
                    $doas = [
                        'id' => $search->id,
                        'slug_category' => $search->categories->slug,
                        'slug' => $search->slug,
                        'category' => $search->categories->name,
                        'title' => $search->title,
                        'content' => $search->content,
                    ];
                    $doa[] = $doas;
                } elseif ($search->categories->slug == 'cerita-hikmah') {
                    $ceritaHikmas = [
                        'id' => $search->id,
                        'slug_category' => $search->categories->slug,
                        'slug' => $search->slug,
                        'category' => $search->categories->name,
                        'title' => $search->title,
                        'content' =>  $search->content,
                    ];
                    $ceritaHikmah[] = $ceritaHikmas;
                }
            }

            $search = [
                'data' => [
                    'quran' => $quran,
                    'hadits' => $hadits,
                    'doa' => $doa,
                    'ceritaHikmah' => $ceritaHikmah,
                ]
            ];
            return $search;
        } catch (\Exception $e) {
            return $this->response->errorInternal($e->getMessage());
        }
    }
}
