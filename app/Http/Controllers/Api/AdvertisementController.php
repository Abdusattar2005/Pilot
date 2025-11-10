<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdvertisementController extends Controller
{
    /**
     * /api/ads/banners
     */
    public function banners()
    {
        $baseUrl = url('/storage/files/advertising/banner');

        $banners = DB::table('advertisements')
            ->select(
                'id',
                'title',
                DB::raw("CONCAT('$baseUrl/', banner) as image"),
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
            ->get();

        return response()->json([
            'success' => true,
            'data' => $banners
        ]);
    }

    /**
     * /api/ads/text-ads?type=vacancy
     * /api/ads/text-ads?type=resume
     */
   public function textAds(Request $request)
    {
        $type = $request->query('type');

        $query = DB::table('text_ads')
            ->select('id', 'title', 'text', 'link', 'type')
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

        $ads = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $ads
        ]);
    }
}