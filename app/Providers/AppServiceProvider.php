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
            'new' => [
                'label' => 'New',
                'description' => 'Latest arrivals in beauty and skincare.',
                'subcategories' => [
                    ['name' => 'Just Arrived', 'slug' => 'just-arrived'],
                    ['name' => 'Bestsellers', 'slug' => 'bestsellers'],
                    ['name' => 'Exclusive', 'slug' => 'exclusive'],
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
            'skincare' => [
                'label' => 'Skincare',
                'description' => 'Glow from within with our curated skincare collections.',
                'subcategories' => [
                    ['name' => 'Cleansers', 'slug' => 'cleansers'],
                    ['name' => 'Moisturizers', 'slug' => 'moisturizers'],
                    ['name' => 'Serums', 'slug' => 'serums'],
                    ['name' => 'Sunscreens', 'slug' => 'sunscreens'],
                    ['name' => 'Face Masks', 'slug' => 'face-masks'],
                ]
            ],
            'fragrance' => [
                'label' => 'Fragrance',
                'description' => 'Timeless scents for every moment.',
                'subcategories' => [
                    ['name' => 'Perfumes', 'slug' => 'perfumes'],
                    ['name' => 'Body Mist', 'slug' => 'body-mist'],
                    ['name' => 'Deodorants', 'slug' => 'deodorants'],
                    ['name' => 'Oils', 'slug' => 'oils'],
                ]
            ],
            'hair' => [
                'label' => 'Hair',
                'description' => 'Professional hair care for every type.',
                'subcategories' => [
                    ['name' => 'Shampoo', 'slug' => 'shampoo'],
                    ['name' => 'Conditioner', 'slug' => 'conditioner'],
                    ['name' => 'Hair Masks', 'slug' => 'hair-masks'],
                    ['name' => 'Tools', 'slug' => 'hair-tools'],
                ]
            ],
            'tools-brushes' => [
                'label' => 'Tools & Brushes',
                'description' => 'The right tools for a perfect finish.',
                'subcategories' => [
                    ['name' => 'Brushes', 'slug' => 'brushes'],
                    ['name' => 'Sponges', 'slug' => 'sponges'],
                    ['name' => 'Styling Tools', 'slug' => 'styling-tools'],
                ]
            ],
            'bath-body' => [
                'label' => 'Bath & Body',
                'description' => 'Luxury care for your body.',
                'subcategories' => [
                    ['name' => 'Body Wash', 'slug' => 'body-wash'],
                    ['name' => 'Lotions', 'slug' => 'lotions'],
                    ['name' => 'Scrubs', 'slug' => 'scrubs'],
                ]
            ],
            'mini-size' => [
                'label' => 'Mini Size',
                'description' => 'Take your favorites everywhere.',
                'subcategories' => [
                    ['name' => 'Travel Sizes', 'slug' => 'travel-sizes'],
                    ['name' => 'Trial Kits', 'slug' => 'trial-kits'],
                ]
            ],
            'brands' => [
                'label' => 'Brands',
                'description' => 'Shop by your favorite brands.',
                'subcategories' => [
                    ['name' => 'Niffer Scents', 'slug' => 'niffer-scents'],
                    ['name' => 'Dior', 'slug' => 'dior'],
                    ['name' => 'Fenty Beauty', 'slug' => 'fenty'],
                ]
            ],
            'gifts' => [
                'label' => 'Gifts & Value Sets',
                'description' => 'Perfect gifts for your loved ones.',
                'is_mega' => true,
                'sections' => [
                    'Shop All' => [
                        ['name' => 'All Gifts', 'slug' => 'all-gifts', 'icon' => 'arrow_forward'],
                        ['name' => 'Gift Guide', 'slug' => 'gift-guide', 'icon' => 'arrow_forward'],
                        ['name' => 'Gift Card', 'slug' => 'gift-card', 'icon' => 'arrow_forward'],
                    ],
                    'By Category' => [
                        ['name' => 'Makeup', 'slug' => 'makeup'],
                        ['name' => 'Skincare', 'slug' => 'skincare'],
                        ['name' => 'Fragrance', 'slug' => 'fragrance'],
                    ],
                    'By Recipient' => [
                        ['name' => 'For Her', 'slug' => 'for-her'],
                        ['name' => 'For Him', 'slug' => 'for-him'],
                        ['name' => 'For Mom', 'slug' => 'for-mom'],
                    ]
                ]
            ],
            'gift-cards' => [
                'label' => 'Gift Cards',
                'description' => 'Give the gift of choice.',
                'subcategories' => [
                    ['name' => 'E-Gift Cards', 'slug' => 'e-gift-cards'],
                    ['name' => 'Physical Cards', 'slug' => 'physical-cards'],
                ]
            ],
            'sale' => [
                'label' => 'Sale & Offers',
                'description' => 'Exclusive deals and discounts.',
                'subcategories' => [
                    ['name' => 'Flash Sale', 'slug' => 'flash-sale'],
                    ['name' => 'Clearance', 'slug' => 'clearance'],
                    ['name' => 'Weekly Offers', 'slug' => 'weekly-offers'],
                ]
            ],
        ];

        view()->share('megaMenuData', $megaMenuData);
        view()->share('all_branches', \App\Models\Branch::all());
    }
}
