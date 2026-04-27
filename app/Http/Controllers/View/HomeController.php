<?php

namespace App\Http\Controllers\View;

use App\Services\Home\HomeDataService;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

/**
 * Вывода главной страницы
 * 
 * @package App\Http\Controllers\View
 */
class HomeController extends Controller
{
    
    public function __construct(
        private HomeDataService $homeDataService
    ) {}

    public function showeHome(): View
    {
        $data = $this->homeDataService->getHomePageData();
        dd("Ghbdnt");
        return view('home.home', $data);
    }
}