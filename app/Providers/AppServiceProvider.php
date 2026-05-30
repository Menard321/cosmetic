<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        // Mega Menu Configuration
        $megaMenuData = [
            'skincare' => [
                'label' => 'Skincare',
                'description' => 'Glow from within with our curated skincare collections.',
                'subcategories' => [
                    ['name' => 'Cleansers', 'slug' => 'cleansers'],
                    ['name' => 'Moisturizers', 'slug' => 'moisturizers'],
                    ['name' => 'Serums', 'slug' => 'serums'],
                    ['name' => 'Sunscreens', 'slug' => 'sunscreens'],
                    ['name' => 'Face Masks', 'slug' => 'face-masks'],
                    ['name' => 'Acne Treatment', 'slug' => 'acne-treatment'],
                    ['name' => 'Exfoliators', 'slug' => 'exfoliators'],
                ]
            ],
            'makeup' => [
                'label' => 'Makeup',
                'description' => 'Define your beauty with professional-grade cosmetic artistry.',
                'subcategories' => [
                    ['name' => 'Foundation', 'slug' => 'foundation'],
                    ['name' => 'Lipsticks', 'slug' => 'lipsticks'],
                    ['name' => 'Eyeshadow', 'slug' => 'eyeshadow'],
                    ['name' => 'Concealer', 'slug' => 'concealer'],
                    ['name' => 'Powder', 'slug' => 'powder'],
                    ['name' => 'Blush', 'slug' => 'blush'],
                ]
            ],
            'wellness' => [
                'label' => 'Wellness',
                'description' => 'Inner health reflects outer beauty. Explore our wellness essentials.',
                'subcategories' => [
                    ['name' => 'Supplements', 'slug' => 'supplements'],
                    ['name' => 'Body Care', 'slug' => 'body-care'],
                    ['name' => 'Skin Vitamins', 'slug' => 'skin-vitamins'],
                    ['name' => 'Herbal Care', 'slug' => 'herbal-care'],
                    ['name' => 'Self-care Products', 'slug' => 'self-care-products'],
                ]
            ],
            'fragrance' => [
                'label' => 'Fragrance',
                'description' => 'Timeless scents for every moment and every personality.',
                'subcategories' => [
                    ['name' => 'Perfumes', 'slug' => 'perfumes'],
                    ['name' => 'Body Mist', 'slug' => 'body-mist'],
                    ['name' => 'Deodorants', 'slug' => 'deodorants'],
                    ['name' => 'Oils', 'slug' => 'oils'],
                ]
            ],
        ];

        view()->share('megaMenuData', $megaMenuData);
        view()->share('all_branches', \App\Models\Branch::all());
    }
}
