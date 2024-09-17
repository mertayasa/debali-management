<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductController;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
        Route::group(['prefix' => 'home', 'as' => 'home.'], function(){
            Route::get('/', [HomePageController::class, 'index'])->name('index');
        });
        Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('create', [CustomerController::class, 'create'])->name('create');
            Route::post('store', [CustomerController::class, 'store'])->name('store');
            Route::get('edit/{customer}', [CustomerController::class, 'edit'])->name('edit');
            Route::patch('update/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::delete('destroy/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('datatable', [CustomerController::class, 'datatable'])->name('datatable');
        });
    });
});