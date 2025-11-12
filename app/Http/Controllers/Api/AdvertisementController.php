<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    /**
     * GET /api/ads/banners
     */
    public function banners()
    {
        $baseUrl = url('/storage/files');

        $banners = DB::table('advertisements')
            ->select(
                'id',
                'title',
                DB::raw("CONCAT('$baseUrl/', banner) as image"),
                'link',
                'description',
                DB::raw("CASE WHEN status = 2 THEN 'Активно' ELSE 'Не активно' END as status")
            )
            ->where('status', 2)
            ->whereDate('start_date', '<=', Carbon::today())
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', Carbon::today());
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $banners
        ]);
    }

    /**
     * GET /api/ads/text-ads?type=vacancy|resume
     */
    public function textAds(Request $request)
    {
        $type = $request->query('type');

        $query = DB::table('text_ads')
            ->select(
                'id',
                'title',
                'text',
                'link',
                'type',
                DB::raw("CASE WHEN status = 2 THEN 'Активно' ELSE 'Не активно' END as status")
            )
            ->where('status', 2)
            ->whereDate('start_date', '<=', Carbon::today())
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', Carbon::today());
            });

        if ($type) {
            if (!in_array($type, ['vacancy', 'resume'])) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid type. Use "vacancy" or "resume".'
                ], 400);
            }
            $query->where('type', $type);
        }

        $ads = $query
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

        return response()->json([
            'success' => true,
            'data' => $ads
        ]);
    }
    public function adsFeed()
{
    $baseUrl = url('/storage/files');

    $banners = DB::table('advertisements')
        ->select(
            'id',
            DB::raw("CONCAT('$baseUrl/', banner) as image"),
            'title',
            'link',
            'description'
        )
        ->where('status', 2)
        ->whereDate('start_date', '<=', Carbon::today())
        ->where(function ($q) {
            $q->whereNull('end_date')
              ->orWhereDate('end_date', '>=', Carbon::today());
        })
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();


    $positions = DB::table('list_positions')
        ->select('id', 'name', 'role_id')
        ->orderBy('id', 'asc')
        ->get()
        ->toArray();

    $textAds = DB::table('text_ads')
        ->select('id', 'title', 'text', 'link')
        ->where('status', 2)
        ->whereDate('start_date', '<=', Carbon::today())
        ->where(function ($q) {
            $q->whereNull('end_date')
              ->orWhereDate('end_date', '>=', Carbon::today());
        })
        ->orderBy('created_at', 'desc')
        ->get()
        ->toArray();

    $feed = [];
    $posCount = count($positions);
    $textCount = count($textAds);

    if ($posCount == 0 || $textCount == 0) {
        return response()->json([
            'success' => true,
            'data' => [
                'banners' => $banners,
                'feed' => [],
            ]
        ]);
    }

    $posIndex = 0;
    $textIndex = 0;

    while ($textIndex < $textCount) {

        for ($i = 0; $i < 5; $i++) {
            $pos = $positions[$posIndex % $posCount];
            $feed[] = [
                'type' => 'position',
                'id' => $pos->id,
                'name' => $pos->name,
                'role_id' => $pos->role_id,
            ];
            $posIndex++;
        }

        if ($textIndex < $textCount) {
            $ad = $textAds[$textIndex];
            $feed[] = [
                'type' => 'text_ad',
                'id' => $ad->id,
                'title' => $ad->title,
                'text' => $ad->text,
                'link' => $ad->link,
            ];
            $textIndex++;
        }
    }

    return response()->json([
        'success' => true,
        'data' => [
            'banners' => $banners,
            'feed' => $feed
        ]
    ]);
}

}