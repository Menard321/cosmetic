<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});

// Temporary dev route to gain admin access
Route::get('/assign-admin', function() {
    if (auth()->check()) {
        auth()->user()->assignRole('admin');
        return "Success! You are now an Admin. <a href='/admin'>Go to Admin Dashboard</a>";
    }
    return "Please login first.";
});

Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

// Role-Protected Dashboards
Route::middleware(['auth', 'role:admin|super-admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.page');
    
    // Inventory Control
    Route::get('admin/inventory', [\App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('admin.inventory.index');
    Route::get('admin/inventory/history', [\App\Http\Controllers\Admin\InventoryController::class, 'history'])->name('admin.inventory.history');
    Route::get('admin/inventory/suppliers', [\App\Http\Controllers\Admin\InventoryController::class, 'suppliers'])->name('admin.inventory.suppliers');
    Route::post('admin/inventory/suppliers', [\App\Http\Controllers\Admin\InventoryController::class, 'storeSupplier'])->name('admin.inventory.suppliers.store');
    Route::get('admin/inventory/restock/{product}', [\App\Http\Controllers\Admin\InventoryController::class, 'restockForm'])->name('admin.inventory.restock');
    Route::post('admin/inventory/restock/{product}', [\App\Http\Controllers\Admin\InventoryController::class, 'restock'])->name('admin.inventory.restock.store');

    // Order Management System
    Route::get('admin/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('admin/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('admin/orders/{order}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('admin.orders.invoice');

    // Customer Management (CRM)
    Route::get('admin/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('admin.customers.index');
    Route::get('admin/customers/{user}', [\App\Http\Controllers\Admin\CustomerController::class, 'show'])->name('admin.customers.show');
    Route::post('admin/customers/{user}/toggle-ban', [\App\Http\Controllers\Admin\CustomerController::class, 'toggleBan'])->name('admin.customers.toggle-ban');
    Route::post('admin/customers/{user}/points', [\App\Http\Controllers\Admin\CustomerController::class, 'updatePoints'])->name('admin.customers.points');

    // Bulk Products
    Route::get('admin/products/bulk', [\App\Http\Controllers\Admin\ProductController::class, 'bulkCreate'])->name('admin.products.bulk');
    Route::post('admin/products/bulk', [\App\Http\Controllers\Admin\ProductController::class, 'bulkStore'])->name('admin.products.bulk.store');

    Route::resource('admin/products', \App\Http\Controllers\Admin\ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor', [App\Http\Controllers\VendorController::class, 'index'])->name('vendor.page');
});

Route::middleware(['auth', 'role:delivery-rider'])->group(function () {
    Route::get('/rider', [App\Http\Controllers\RiderController::class, 'index'])->name('rider.page');
});

Route::get('/category/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->middleware('auth')->name('category.show');

// Product Routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->middleware('auth')->name('products.index');
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show'])->middleware('auth')->name('products.show');

// Cart Routes
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::patch('/update-cart', [App\Http\Controllers\CartController::class, 'update'])->name('update.cart');
// Fixed incorrect route: remove-from-cart should use ID or match controller
Route::delete('/remove-from-cart', [App\Http\Controllers\CartController::class, 'remove'])->name('remove.from.cart');

// Checkout Routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->middleware('auth')->name('checkout.index');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->middleware('auth')->name('checkout.store');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/customer/orders', [App\Http\Controllers\CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/customer/wishlist', [App\Http\Controllers\CustomerController::class, 'wishlist'])->name('customer.wishlist');
    Route::get('/customer/addresses', [App\Http\Controllers\CustomerController::class, 'addresses'])->name('customer.addresses');
    Route::get('/customer/notifications', [App\Http\Controllers\CustomerController::class, 'notifications'])->name('customer.notifications');
    Route::get('/customer/loyalty', [App\Http\Controllers\CustomerController::class, 'loyalty'])->name('customer.loyalty');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
