<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConsultationController;
use Illuminate\Support\Facades\Route;

// Footer Pages
Route::get('/brand-story', [App\Http\Controllers\PageController::class, 'brandStory'])->name('pages.brand-story');
Route::get('/store-locator', [App\Http\Controllers\PageController::class, 'storeLocator'])->name('pages.store-locator');
Route::get('/mpesa-guide', [App\Http\Controllers\PageController::class, 'mpesaGuide'])->name('pages.mpesa-guide');
Route::get('/shipping-policy', [App\Http\Controllers\PageController::class, 'shippingPolicy'])->name('pages.shipping-policy');
Route::get('/return-policy', [App\Http\Controllers\PageController::class, 'returnPolicy'])->name('pages.return-policy');
Route::get('/privacy-policy', [App\Http\Controllers\PageController::class, 'privacyPolicy'])->name('pages.privacy-policy');
Route::get('/contact-us', [App\Http\Controllers\PageController::class, 'contactUs'])->name('pages.contact');
Route::get('/track-order', [App\Http\Controllers\PageController::class, 'trackOrder'])->name('pages.track-order');
Route::post('/track-order/search', [App\Http\Controllers\PageController::class, 'trackOrderSearch'])->name('pages.track-order.search');

// Branch Support
Route::get('/branches', [\App\Http\Controllers\BranchController::class, 'index'])->name('branches.index');
Route::get('/branches/{branch:slug}', [\App\Http\Controllers\BranchController::class, 'switch'])->name('branches.switch');
Route::get('/location/{branch:slug}', [\App\Http\Controllers\BranchController::class, 'show'])->name('branches.show');

// Loyalty System
Route::middleware(['auth'])->group(function () {
    Route::get('/loyalty', [App\Http\Controllers\LoyaltyController::class, 'dashboard'])->name('customer.loyalty');
    Route::post('/loyalty/redeem/{reward}', [App\Http\Controllers\LoyaltyController::class, 'redeem'])->name('customer.loyalty.redeem');
    Route::post('/loyalty/events/{event}/book', [App\Http\Controllers\LoyaltyController::class, 'bookEvent'])->name('customer.loyalty.book-event');
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

    // Admin Consultation Management
    Route::get('admin/consultations', [ConsultationController::class, 'adminIndex'])->name('admin.consultations.index');
    Route::patch('admin/consultations/{consultation}/status', [ConsultationController::class, 'updateStatus'])->name('admin.consultations.updateStatus');
    
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

    // Enterprise Expansion Routes
    Route::get('admin/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('admin.analytics.index');
    Route::get('admin/delivery', [\App\Http\Controllers\Admin\DeliveryController::class, 'index'])->name('admin.delivery.index');
    Route::get('admin/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('admin.notifications.index');
    Route::post('admin/notifications/send', [\App\Http\Controllers\Admin\NotificationController::class, 'sendCampaign'])->name('admin.notifications.send');

    // Loyalty & CRM Intelligence
    Route::prefix('admin/loyalty')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\LoyaltyManagementController::class, 'index'])->name('admin.loyalty.index');
        Route::resource('campaigns', \App\Http\Controllers\Admin\LoyaltyCampaignController::class)->names('admin.loyalty.campaigns');
        Route::resource('tiers', \App\Http\Controllers\Admin\LoyaltyTierController::class)->names('admin.loyalty.tiers');
        Route::resource('events', \App\Http\Controllers\Admin\BeautyEventController::class)->names('admin.loyalty.events');
        Route::patch('events/tickets/{ticket}/check-in', [\App\Http\Controllers\Admin\BeautyEventController::class, 'checkInTicket'])->name('admin.loyalty.events.check-in');
        Route::get('redemptions', [\App\Http\Controllers\Admin\LoyaltyManagementController::class, 'redemptions'])->name('admin.loyalty.redemptions');
    });

    // EMS - Employee Management System
    Route::prefix('admin/ems')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\EmployeeController::class, 'dashboard'])->name('admin.ems.dashboard');
        
        // Employees
        Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class)->names([
            'index' => 'admin.ems.employees.index',
            'create' => 'admin.ems.employees.create',
            'store' => 'admin.ems.employees.store',
            'show' => 'admin.ems.employees.show',
            'edit' => 'admin.ems.employees.edit',
            'update' => 'admin.ems.employees.update',
            'destroy' => 'admin.ems.employees.destroy',
        ]);

        // Attendance
        Route::get('attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('admin.ems.attendance.index');
        Route::post('attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'store'])->name('admin.ems.attendance.store');
        Route::post('attendance/bulk', [\App\Http\Controllers\Admin\AttendanceController::class, 'markPresent'])->name('admin.ems.attendance.bulk');

        // Leaves
        Route::get('leaves', [\App\Http\Controllers\Admin\LeaveController::class, 'index'])->name('admin.ems.leaves.index');
        Route::post('leaves', [\App\Http\Controllers\Admin\LeaveController::class, 'store'])->name('admin.ems.leaves.store');
        Route::patch('leaves/{leaveRequest}/approve', [\App\Http\Controllers\Admin\LeaveController::class, 'approve'])->name('admin.ems.leaves.approve');
        Route::patch('leaves/{leaveRequest}/reject', [\App\Http\Controllers\Admin\LeaveController::class, 'reject'])->name('admin.ems.leaves.reject');

        // Payroll
        Route::get('payroll', [\App\Http\Controllers\Admin\PayrollController::class, 'index'])->name('admin.ems.payroll.index');
        Route::post('payroll/generate', [\App\Http\Controllers\Admin\PayrollController::class, 'generatePayroll'])->name('admin.ems.payroll.generate');
        Route::patch('payroll/{payrollRecord}/pay', [\App\Http\Controllers\Admin\PayrollController::class, 'markPaid'])->name('admin.ems.payroll.mark-paid');
        Route::post('payroll/bulk-pay', [\App\Http\Controllers\Admin\PayrollController::class, 'bulkMarkPaid'])->name('admin.ems.payroll.bulk-pay');

        // Performance
        Route::get('performance', [\App\Http\Controllers\Admin\PerformanceController::class, 'index'])->name('admin.ems.performance.index');
        Route::post('performance', [\App\Http\Controllers\Admin\PerformanceController::class, 'store'])->name('admin.ems.performance.store');

        // Shifts
        Route::resource('shifts', \App\Http\Controllers\Admin\ShiftController::class)->names([
            'index' => 'admin.ems.shifts.index',
            'store' => 'admin.ems.shifts.store',
            'update' => 'admin.ems.shifts.update',
            'destroy' => 'admin.ems.shifts.destroy',
        ])->only(['index', 'store', 'update', 'destroy']);

        Route::get('shift-assignments', [\App\Http\Controllers\Admin\EmployeeShiftController::class, 'index'])->name('admin.ems.shifts.assignments');
        Route::post('shift-assignments', [\App\Http\Controllers\Admin\EmployeeShiftController::class, 'store'])->name('admin.ems.shifts.assignments.store');
        Route::delete('shift-assignments/{id}', [\App\Http\Controllers\Admin\EmployeeShiftController::class, 'destroy'])->name('admin.ems.shifts.assignments.destroy');

        // Transfers
        Route::get('transfers', [\App\Http\Controllers\Admin\TransferController::class, 'index'])->name('admin.ems.transfers.index');
        Route::post('transfers', [\App\Http\Controllers\Admin\TransferController::class, 'store'])->name('admin.ems.transfers.store');
        // Corrected parameter name from transfer to employeeTransfer to match route binder
        Route::patch('transfers/{employeeTransfer}/approve', [\App\Http\Controllers\Admin\TransferController::class, 'approve'])->name('admin.ems.transfers.approve');
        Route::patch('transfers/{employeeTransfer}/cancel', [\App\Http\Controllers\Admin\TransferController::class, 'cancel'])->name('admin.ems.transfers.cancel');

        // Reports
        Route::get('reports', [\App\Http\Controllers\Admin\HRReportController::class, 'index'])->name('admin.ems.reports.index');
    });
});

Route::middleware(['auth', 'role:vendor'])->group(function () {
    Route::get('/vendor', [App\Http\Controllers\VendorController::class, 'index'])->name('vendor.page');
});

Route::middleware(['auth', 'role:delivery-rider'])->group(function () {
    Route::get('/rider', [App\Http\Controllers\RiderController::class, 'index'])->name('rider.page');
});

Route::get('/category/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->middleware('auth')->name('category.show');
Route::get('/category/{category}/{subcategory}', [App\Http\Controllers\CategoryController::class, 'subcategory'])->middleware('auth')->name('category.subcategory');

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
Route::post('/order/{order}/verify-payment', [App\Http\Controllers\CheckoutController::class, 'verifyPaymentStatus'])->middleware('auth')->name('order.verify-payment');

// Consultation Routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/consultation/book', [ConsultationController::class, 'create'])->name('consultation.create');
    Route::post('/consultation/book', [ConsultationController::class, 'store'])->name('consultation.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [App\Http\Controllers\CustomerController::class, 'orders'])->name('customer.orders');
    Route::get('/orders/{order}', [App\Http\Controllers\CustomerController::class, 'showOrder'])->name('customer.orders.show');
    Route::get('/wishlist', [App\Http\Controllers\CustomerController::class, 'wishlist'])->name('customer.wishlist');
    Route::get('/customer/addresses', [App\Http\Controllers\CustomerController::class, 'addresses'])->name('customer.addresses');
    Route::get('/customer/notifications', [App\Http\Controllers\CustomerController::class, 'notifications'])->name('customer.notifications');
    Route::get('/customer/loyalty', [App\Http\Controllers\CustomerController::class, 'loyalty'])->name('customer.loyalty');
});

// Beauty AI Route
Route::post('/beauty-ai/chat', [App\Http\Controllers\AIController::class, 'chat'])->name('beauty-ai.chat');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/{any}', function () {
    return redirect()->route('home');
})->where('any', '.*');
