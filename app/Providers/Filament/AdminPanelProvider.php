<?php

namespace App\Providers\Filament;

use Filament\Panel;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Pages;
use Filament\PanelProvider;
use Filament\Facades\Filament;
use Filament\Support\Colors\Color;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('perpus')
            
            // ============================================
            // CUSTOM LOGIN & BRANDING
            // ============================================
            // ->brandName('SMPN 181 Jakarta - Perpustakaan')
            // ->brandLogo(asset('storage/icons/savansa.png'))
            ->brandLogoHeight('3rem')
            ->favicon(asset('storage/icons/savansa.png'))
            
            // Dark Mode Default
            ->darkMode(true)
            // ->defaultThemeMode('dark')
            ->login()
            ->sidebarCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/admin/theme.css')
            // Colors - Blue Primary
            ->colors([
                'primary' => Color::Blue,
                // 'gray' => Color::Slate,
                // Color::Blue
            ])
            
            // ============================================
            // Resources, Pages, Widgets
            // ============================================
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            
            // ============================================
            // Middleware
            // ============================================
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            
            // ============================================
            // Plugins
            // ============================================
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}