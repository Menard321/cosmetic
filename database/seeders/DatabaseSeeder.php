<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('super-admin');

        $skincare = \App\Models\Category::create(['name' => 'Skincare', 'slug' => 'skincare', 'description' => 'Skincare category']);
        $makeup = \App\Models\Category::create(['name' => 'Makeup', 'slug' => 'makeup', 'description' => 'Makeup category']);
        $fragrance = \App\Models\Category::create(['name' => 'Fragrance', 'slug' => 'fragrance', 'description' => 'Fragrance category']);
        $wellness = \App\Models\Category::create(['name' => 'Wellness', 'slug' => 'wellness', 'description' => 'Wellness category']);

        $p1 = \App\Models\Product::create([
            'category_id' => $skincare->id,
            'name' => 'Revitalift Crystal Essence',
            'brand' => "L'ORÉAL PARIS",
            'price' => 145000,
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDijkKx7ZhPOC-EbzgMOy5JSRmDGPLpIuDLc7vicy_kEjCAcP6HW4DTG-A8UbBKe_AIqI0_I70LBl7G2pd3gvFavQ_ninvSi1A8jwmipXkW9FHcjWeUszvEcmGrqKwRp9LAWDtD88wd4KLoVvW-_fkCP0jme7I8eq_1CJMM2NsM3tYuflt60t9rkUOP7LFl20tWp1wB7fLmq8HL8nYcVm8FjvIPPyQ4uLTH_YRf9zXKS0BlbhTaUyg_fKw_RO5mhqOL0dPTbPONlFI',
            'is_trending' => true,
            'stock_quantity' => 45
        ]);

        $p2 = \App\Models\Product::create([
            'category_id' => $fragrance->id,
            'name' => 'Eau De Parfum',
            'brand' => 'FENTY BEAUTY',
            'price' => 320000,
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC6e2JPtmotgURc2koYV2YlbaYENiim2WyRnLUt_NUyZTW6fQqtc0SGUyZSsemz0M88oXKLK61DbXvlPlf3kxsNY0RMYRi0bwiuuoOvydK1B-pOk1gubpJQHfhEAUi5Es7894o2hqTQkCtEUnpzQWqNY6zNDxte9eEChve6heat015dHQ2s3d_uoXqWvTU-iEQkWnkjgGScdxo1JtMd__SN1MgW6e_oZoNCPWmJzJ9dOWt0W2MDqNG0Nvb56pDPXPLNo17DnpJNdPE',
            'is_trending' => true,
            'stock_quantity' => 12
        ]);

        $p3 = \App\Models\Product::create([
            'category_id' => $skincare->id,
            'name' => 'Swahili Coast Shea Butter',
            'brand' => 'LOCAL BRAND',
            'price' => 45000,
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAR8AlSk7mabGQqqeWbvm0zWiNaOv0hSsbEXKhYXFBeDrIdscNgptUdJ7ZI2SJ2g71m7Jo08b2LfCTJh73H5JW2A61fggz3D2-Hkl80UJ2B9Br8ydKmfz68XAuUY-xowqLuds-iqxPRcuG5SEgBnpJHrfH4xB9o4qHAd6RREKDvW4cw9HrRQNhlf6p3awPicJTShPyeuzxwq_amDeu16QBjUQks41iEy32WNWW5ywNuVxaiz9hz4CU2DJLwx4T7iGDjKYmgGtL9Gi8',
            'is_trending' => true,
            'stock_quantity' => 4
        ]);

        $p4 = \App\Models\Product::create([
            'category_id' => $makeup->id,
            'name' => 'Rouge Velvet Edition',
            'brand' => 'DIOR',
            'price' => 115000,
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB-0wtSPaGRhFM2aGVe2y7fDK7vGo_UA4R_LiaW7BPbvLprdIR2OMSFIhjS1gt0CqgZuhhwYwR-GifyhDbPeq7HRrM-UtjHQ_pME43Mi46hMERcs8Ir3A7g2AwRNiXb0y0iBckgVKJqYc0yC_m9GZkA17o7f1xpXdsGMWk70zrEMyWK09cns5smGFceszLaD_LIoFvOkSDAjTT-PycTxoUwAD9B758MPcxJwq3WvrD5JG8JlD4mkTNKnQ-A6sVj8i4HoZcebL5Nmnc',
            'is_trending' => true,
            'stock_quantity' => 8
        ]);

        $p5 = \App\Models\Product::create([
            'category_id' => $wellness->id,
            'name' => 'Pure Jade Roller Set',
            'brand' => 'WELLNESS CO',
            'price' => 65000,
            'image_url' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA5FkxLui4WXDvg12Ei0YMsW1OGLz24pA6-svWgJEC93HGVBn9mOom-xqoRCdI92q6lueztDgjHO8z0fbchIc2EJ_NJoAQLSkxjWGXorB6lTUnNUugJ46aQOhwfB4KT33ZeXvyrOFB7waGgvtQ_vI7ynPIvkD97T2AICrt_XEbvABnmIT3RJlM-_brpuFdcI3_GfRiFBlWCDTbTewpPstaNePl5uQ6-zIDo4KLMSeHsJnWfoRoMpjV8FqhGeGyxdd6ML0VUN9dvioA',
            'is_trending' => false,
            'stock_quantity' => 30
        ]);

        // Seed Orders for Admin Analytics
        for ($i = 0; $i < 5; $i++) {
            $order = \App\Models\Order::create([
                'customer_name' => 'Customer ' . $i,
                'phone' => '07XX XXX XXX',
                'payment_method' => 'M-Pesa',
                'total_amount' => 0,
                'status' => 'completed',
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p1->id,
                'quantity' => 1,
                'price' => $p1->price,
            ]);

            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $p2->id,
                'quantity' => 2,
                'price' => $p2->price,
            ]);

            $order->update(['total_amount' => $p1->price + ($p2->price * 2)]);
        }
    }
}
