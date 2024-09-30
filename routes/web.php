<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
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
            Route::get('show/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::patch('update/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::delete('destroy/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
            Route::get('datatable', [CustomerController::class, 'datatable'])->name('datatable');
        });

        Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('create', [ProductController::class, 'create'])->name('create');
            Route::post('store', [ProductController::class, 'store'])->name('store');
            Route::get('edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::patch('update/{product}', [ProductController::class, 'update'])->name('update');
            Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->name('destroy');
            Route::get('datatable', [ProductController::class, 'datatable'])->name('datatable');
        });

        Route::group(['prefix' => 'expense', 'as' => 'expense.'], function () {
            Route::get('/', [ExpenseController::class, 'index'])->name('index');
            Route::get('create', [ExpenseController::class, 'create'])->name('create');
            Route::post('store', [ExpenseController::class, 'store'])->name('store');
            Route::delete('destroy/{expense}', [ExpenseController::class, 'destroy'])->name('destroy');
            Route::get('datatable', [ExpenseController::class, 'datatable'])->name('datatable');
        });

        Route::group(['prefix' => 'sale', 'as' => 'sale.'], function () {
            Route::get('/', [SaleController::class, 'index'])->name('index');
            Route::get('create', [SaleController::class, 'create'])->name('create');
            Route::post('store', [SaleController::class, 'store'])->name('store');
            Route::get('edit/{sale}', [SaleController::class, 'edit'])->name('edit');
            Route::patch('update/{sale}', [SaleController::class, 'update'])->name('update');
            Route::delete('destroy/{sale}', [SaleController::class, 'destroy'])->name('destroy');
            Route::get('datatable', [SaleController::class, 'datatable'])->name('datatable');
        });
    });
});