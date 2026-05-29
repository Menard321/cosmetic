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
        $this->call([
            RolesAndPermissionsSeeder::class,
            BranchSeeder::class,
        ]);
        
        // User::factory(10)->create();

        $admin = User::factory()->create([
            'name' => 'Joseph Menard',
            'email' => 'menardjoseph23@gmail.com',
            'password' => bcrypt('password')
        ]);
        $admin->assignRole('super-admin');

        $skincare = \App\Models\Category::create(['name' => 'Skincare', 'slug' => 'skincare', 'description' => 'Skincare category']);
        $makeup = \App\Models\Category::create(['name' => 'Makeup', 'slug' => 'makeup', 'description' => 'Makeup category']);
        $fragrance = \App\Models\Category::create(['name' => 'Fragrance', 'slug' => 'fragrance', 'description' => 'Fragrance category']);
        $wellness = \App\Models\Category::create(['name' => 'Wellness', 'slug' => 'wellness', 'description' => 'Wellness category']);

        $p1 = \App\Models\Product::create([
            'category_id' => $skincare->id,
            'name' => 'SEASHELLS',
            'brand' => "Niffer Scents",
            'price' => 145000,
            'image_url' => '/niffer/9.jpeg',
            'is_trending' => true,
            'stock_quantity' => 45
        ]);

        $p2 = \App\Models\Product::create([
            'category_id' => $fragrance->id,
            'name' => 'UNDEFINED',
            'brand' => 'Niffer Scents',
            'price' => 320000,
            'image_url' => '/niffer/10.jpeg',
            'is_trending' => true,
            'stock_quantity' => 12
        ]);

        $p3 = \App\Models\Product::create([
            'category_id' => $skincare->id,
            'name' => 'ELEGANT',
            'brand' => 'Niffer Scents',
            'price' => 45000,
            'image_url' => '/niffer/11.jpeg',
            'is_trending' => true,
            'stock_quantity' => 4
        ]);

        $p4 = \App\Models\Product::create([
            'category_id' => $makeup->id,
            'name' => 'SWEET',
            'brand' => 'Niffer Scents',
            'price' => 115000,
            'image_url' => '/niffer/12.jpeg',
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
        $branches = \App\Models\Branch::all();
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

            $order->update([
                'total_amount' => $p1->price + ($p2->price * 2),
                'branch_id' => $branches->first()->id
            ]);
        }

        // Distribute stock across branches
        $allProducts = \App\Models\Product::all();
        $branches = \App\Models\Branch::all();

        foreach ($allProducts as $product) {
            foreach ($branches as $branch) {
                \App\Models\BranchInventory::create([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'stock_quantity' => rand(5, 50),
                    'is_available' => true
                ]);
            }
        }
    }
}
