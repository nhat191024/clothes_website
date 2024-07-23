<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\HomeService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $homeService;
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }
    public function index()
    {
        $newProductInfo = $this->homeService->newProducts();
        $trendProductInfo = $this->homeService->trendProduct();
        $favoriteProductInfo = $this->homeService->favoriteProduct();
        $productAmount = collect($this->homeService->productAmount());
        $collectionBanner = $this->homeService->collectionBanner();
        // return $productAmount;
        $latestPromotion = $this->homeService->latestPromotion();
        if ($latestPromotion) {
            $start_time = Carbon::parse($latestPromotion->start_time);
            $end_time = Carbon::parse($latestPromotion->end_time);
        }
        $latestPromotion->daysDiff = $end_time->day - $start_time->day;
        $latestPromotion->hoursDiff = $end_time->hour - $start_time->hour;
        $latestPromotion->minsDiff = $end_time->minute - $start_time->minute;
        $latestPromotion->secsDiff = $end_time->second - $start_time->second;
        return view('client.home.index', compact('newProductInfo', 'trendProductInfo', 'favoriteProductInfo', 'latestPromotion', 'productAmount', 'collectionBanner'));
    }
}
