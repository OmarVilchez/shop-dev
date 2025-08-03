<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {

        $banners = \App\Models\Banner::query()
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            })
            ->orderBy('position')
            ->get();



        return view('welcome', compact(
            'banners'
        ));
    }
}




        // Sliders activos y vigentes
       /*  $banners = Cache::remember('home_sliders', 3600, function () {
            return Banner::where(function ($query) {
                $query->where([['starts_at', '<=', now()], ['ends_at', '>=', now()]]);
            })->orWhere(function ($query) {
                $query->whereNull('starts_at')->whereNull('ends_at');
            })->where('active', true)
                ->orderBy('position', 'asc')
                ->get();
        }); */
