<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactFunctionController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ProposalLineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    /**
     * ============================
     * ENTITIES
     * ============================
     */
    Route::get('/entities', [EntityController::class, 'index'])->name('entities.index');
    Route::get('/entities/create', [EntityController::class, 'create'])->name('entities.create');
    Route::post('/entities', [EntityController::class, 'store'])->name('entities.store');
    Route::get('/entities/{entity}/edit', [EntityController::class, 'edit'])->name('entities.edit');
    Route::put('/entities/{entity}', [EntityController::class, 'update'])->name('entities.update');
    Route::delete('/entities/{entity}', [EntityController::class, 'destroy'])->name('entities.destroy');


    /**
     * ============================
     * CONTACTS
     * ============================
     */
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');


    /**
     * ============================
     * CONTACT FUNCTIONS
     * ============================
     */
    Route::get('/contact-functions', [ContactFunctionController::class, 'index'])->name('functions.index');
    Route::get('/contact-functions/create', [ContactFunctionController::class, 'create'])->name('functions.create');
    Route::post('/contact-functions', [ContactFunctionController::class, 'store'])->name('functions.store');
    Route::get('/contact-functions/{func}/edit', [ContactFunctionController::class, 'edit'])->name('functions.edit');
    Route::put('/contact-functions/{func}', [ContactFunctionController::class, 'update'])->name('functions.update');
    Route::delete('/contact-functions/{func}', [ContactFunctionController::class, 'destroy'])->name('functions.destroy');


    Route::resource('items', ItemController::class);

    Route::resource('proposals', ProposalController::class);

    Route::resource('proposal-lines', ProposalLineController::class);

    Route::resource('orders', OrderController::class);

    // Converter proposta → encomenda
    Route::post('/proposals/{proposal}/convert-to-order', [ProposalController::class, 'convertToOrder'])
        ->name('proposals.convertToOrder');

    // Converter encomenda → encomendas fornecedor
    Route::post('/orders/{order}/convert-to-supplier-orders', [OrderController::class, 'convertToSupplierOrders'])
        ->name('orders.convertToSupplierOrders');

    // Download PDF
    Route::get('/orders/{order}/pdf', [OrderController::class, 'pdf'])->name('orders.pdf');

    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('calendar/events', [CalendarController::class, 'events'])->name('calendar.events');
    Route::get('calendar/create', [CalendarController::class, 'create'])->name('calendar.create');
    Route::post('calendar', [CalendarController::class, 'store'])->name('calendar.store');
    Route::get('calendar/{activity}/edit', [CalendarController::class, 'edit'])->name('calendar.edit');
    Route::put('calendar/{activity}', [CalendarController::class, 'update'])->name('calendar.update');
    Route::delete('calendar/{activity}', [CalendarController::class, 'destroy'])->name('calendar.destroy');

    // Tenant routes
    Route::get('/tenants', [TenantController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/create', [TenantController::class, 'create'])->name('tenants.create');
    Route::post('/tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::get('/tenants/{tenant}/edit', [TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [TenantController::class, 'update'])->name('tenants.update');
    Route::get('/tenants/{tenant}/switch', [TenantController::class, 'switch'])->name('tenants.switch');

    // Onboarding routes
    Route::prefix('onboarding')->name('onboarding.')->group(function () {
        Route::get('/', [OnboardingController::class, 'index'])->name('index');
        Route::post('/welcome', [OnboardingController::class, 'welcome'])->name('welcome');
        Route::post('/branding', [OnboardingController::class, 'branding'])->name('branding');
        Route::post('/team', [OnboardingController::class, 'team'])->name('team');
        Route::post('/preferences', [OnboardingController::class, 'preferences'])->name('preferences');
        Route::post('/skip', [OnboardingController::class, 'skip'])->name('skip');
    });
    // Plans routes
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/{plan}', [PlanController::class, 'show'])->name('plans.show');

    // Subscription routes
    Route::prefix('subscription')->name('subscriptions.')->group(function () {
        Route::get('/dashboard', [SubscriptionController::class, 'dashboard'])->name('dashboard');
        Route::post('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
        Route::post('/upgrade/{plan}', [SubscriptionController::class, 'upgrade'])->name('upgrade');
        Route::post('/downgrade/{plan}', [SubscriptionController::class, 'downgrade'])->name('downgrade');
        Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
    });

});
