<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Blade;

use Illuminate\Http\Request;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        // Konfigurasi batasan login (3 kali dalam 5 menit)
        RateLimiter::for('nova.login', function ($request) {
            return Limit::perMinute(3)->by($request->ip())->response(function () {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan login. Silakan coba lagi dalam beberapa menit.'
                ], 429);
            });
        });
        

        // Tambahkan middleware throttle ke Nova
        Nova::router(['web', 'nova', 'throttle:nova.login'])->group(function ($router) {
            Route::get('/login', '\Laravel\Nova\Http\Controllers\LoginController@showLoginForm')->name('nova.login');
            Route::post('/login', '\Laravel\Nova\Http\Controllers\LoginController@login');
        });

        
        Nova::style('custom', public_path('css/custom.css'));
        Nova::footer(function ($request) {
            return Blade::render(config('app.name'));
        });

        Nova::mainMenu(function (Request $request) {
            $mnu = [
                MenuSection::dashboard(Main::class)->icon('chart-pie'),

                //MenuSection::resource(\App\Nova\TypeWebsite::class)->withBadge('New!', 'info')->icon('document-text'),
                MenuSection::resource(\App\Nova\TypeWebsite::class)->icon('document-text'),
                MenuSection::make('Homepage', [                    
                    MenuItem::resource(\App\Nova\HeroBanner::class),                    
                    MenuItem::resource(\App\Nova\Promo::class),                    
                    MenuItem::resource(\App\Nova\News::class),                    
                    MenuItem::resource(\App\Nova\Education::class),                    
                    MenuItem::resource(\App\Nova\Sbdk::class),                    
                    MenuItem::resource(\App\Nova\CreditCalculator::class),                    
                    MenuItem::resource(\App\Nova\ExchangeRate::class),                    
                ])->icon('home')->collapsable(),
                
                MenuSection::make('Product', [
                    //MenuItem::resource(\App\Nova\TypeWebsite::class),
                    MenuItem::resource(\App\Nova\ProductCategory::class),
                    //MenuItem::resource(\App\Nova\ProductType::class),
                    MenuItem::resource(\App\Nova\Product::class),                    
                ])->icon('credit-card')->collapsable(),

                MenuSection::resource(\App\Nova\Service::class)->icon('newspaper'),
                // MenuSection::make('Services', [                    
                //     MenuItem::resource(\App\Nova\ServiceCategory::class),                    
                //     MenuItem::resource(\App\Nova\Service::class),                    
                // ])->icon('credit-card')->collapsable(),
                                
                MenuSection::make('Informasi', [
                    MenuItem::resource(\App\Nova\InformationCategory::class),               
                    MenuItem::resource(\App\Nova\Syariah::class),               
                ])->icon('information-circle')->collapsable(),
                
                MenuSection::make('Profile', [
                    MenuItem::resource(\App\Nova\ProfileCategory::class),               
                    MenuItem::resource(\App\Nova\CorporateGovernanceCategory::class),               
                    MenuItem::resource(\App\Nova\InformationFinanceCategory::class),               
                    MenuItem::resource(\App\Nova\Policy::class),               
                    MenuItem::resource(\App\Nova\CSR::class),               
                    MenuItem::resource(\App\Nova\SustainableCategory::class),               
                    MenuItem::resource(\App\Nova\Award::class),               
                ])->icon('presentation-chart-bar')->collapsable(),
                
                MenuSection::resource(\App\Nova\ContactUs::class)->icon('phone'),
                MenuSection::resource(\App\Nova\Location::class)->icon('map'),                
                MenuSection::resource(\App\Nova\Carrier::class)->icon('users'),                
                MenuSection::resource(\App\Nova\Aksel::class)->icon('device-tablet'),                
            ];

            $mnu[] = MenuSection::make('Settings', array_filter([
                        MenuItem::resource(\App\Nova\User::class),  
                        MenuItem::resource(\App\Nova\UnitTeam::class),  
                        auth()->user()->isSuperAdmin() 
                            ? MenuItem::make('Roles')->path('/resources/roles') 
                            : null,
                        auth()->user()->isSuperAdmin() 
                            ? MenuItem::make('Permissions')->path('/resources/permissions') 
                            : null,

                        MenuItem::make('Two FA')->path('/nova-two-factor')
                    ]))->icon('cog')->collapsable();
        
            return $mnu;
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes(default: true)
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                $user->email,
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            (new \Sereny\NovaPermissions\NovaPermissions())->canSee(function ($request) {
                return $request->user()->isSuperAdmin();
            }),
            new \Visanduma\NovaTwoFactor\NovaTwoFactor(),
            //new \Sereny\NovaPermissions\NovaPermissions(),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
