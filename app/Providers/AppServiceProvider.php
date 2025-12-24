<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Filament\Widgets\Widget;
use Filament\Resources\Resource;
use Filament\View\PanelsRenderHook;
use Filament\Pages\BasePage as Page;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

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
        // FilamentShield::buildPermissionKeyUsing(
        //     function (string $entity, string $affix, string $subject, string $case, string $separator) {
        //         return match(true) {
        //             # if `configurePermissionIdentifierUsing()` was used previously, then this needs to be adjusted accordingly
        //             is_subclass_of($entity, Resource::class) => Str::of($affix)
        //                 ->snake()
        //                 ->append('_')
        //                 ->append(
        //                     Str::of($entity)
        //                         ->afterLast('\\')
        //                         ->beforeLast('Resource')
        //                         ->replace('\\', '')
        //                         ->snake()
        //                         ->replace('_', '::')
        //                 )
        //                 ->toString(),
        //             is_subclass_of($entity, Page::class) => Str::of('page_')
        //                 ->append(class_basename($entity))
        //                 ->toString(),
        //             is_subclass_of($entity, Widget::class) => Str::of('widget_')
        //                 ->append(class_basename($entity))
        //                 ->toString()
        //             };
        //     });

        Carbon::setLocale(config('app.locale'));
        Carbon::setLocale('id');

                // Add a link above the login form
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            fn (): string => Blade::render('<x-filament::link href="' . config('app.url') . '" size="sm" icon="heroicon-o-arrow-left">Halaman Landing Page</x-filament::link>')
        );

        // Add a link above the register form
        FilamentView::registerRenderHook(
            PanelsRenderHook::AUTH_REGISTER_FORM_AFTER,
            fn (): string => Blade::render('<x-filament::link href="' . config('app.url') . '" size="sm" icon="heroicon-o-arrow-left">Halaman Landing Page</x-filament::link>')
        );

    }
}
