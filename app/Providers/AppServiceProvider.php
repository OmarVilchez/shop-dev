<?php

namespace App\Providers;

use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        SEOTools::macro('webPage', function (?string $title, ?string $description, ?string $keywords, ?string $url = 'inicio', ?string $type = 'webpage', ?string $image = 'images/dirkko-peru.jpg', ?string $alt) {
            SEOMeta::setTitle($title ?? '');
            SEOMeta::setDescription($description ?? '');
            SEOMeta::setKeywords($keywords ?? '');
            // SEOMeta::setCanonical(config('app.url') . '/' . ($url !== null ? $url : 'inicio'));
            SEOMeta::setCanonical(config('app.url') . ($url !== null && $url !== 'home' ? '/' . $url : ''));
            SEOMeta::addMeta('author', config('app.name'));
            SEOMeta::addMeta('copyright', config('app.name'));
            SEOMeta::addMeta('language', 'es-PE');
            SEOMeta::addMeta('country', 'PER');

            OpenGraph::setDescription($description ?? '');
            OpenGraph::setTitle($title ?? '');
            OpenGraph::setType($type !== null ? $type : 'webpage');
            // OpenGraph::setUrl(config('app.url') . '/' . ($url !== null ? $url : 'inicio'));
            OpenGraph::setUrl(config('app.url') . ($url !== null && $url !== 'home' ? '/' . $url : ''));
            OpenGraph::addImage(config('app.url') . '/storage/' . ($image !== null ? $image : 'images/dirkko-peru.jpg'));
            OpenGraph::addProperty('image:alt', ($alt !== null ? $alt : config('app.name')));
            OpenGraph::addProperty('image:secure_url', config('app.url') . '/storage/' . ($image !== null ? $image : 'images/dirkko-peru.jpg'));
           // OpenGraph::addProperty('fb:app_id', '1496092071055893');
        });
    }
}
