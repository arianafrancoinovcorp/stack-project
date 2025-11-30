<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactFunctionController;

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

});
