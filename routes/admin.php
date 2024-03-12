<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesController;
use Illuminate\Support\Facades\Route;




    Route::group([
        'middleware' => ['auth','auth.type:admin,super-admin'],
        'as' => 'dashboard.',
        'prefix' => 'admin/dashboard',

    ], function () {

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/',[HomeController::class,'index'])->name('dashboard');

    Route::get('/categories/trash', [CategoryController::class, 'trash'])
    ->name('categories.trash');  //الترتيب مهم
    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])
    ->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategoryController::class, 'forceDelete'])
    ->name('categories.force-delete');


    Route::resource('categories',CategoryController::class);
    Route::resource('products',ProductController::class);
    Route::resource('roles',RolesController::class);

});
?>
