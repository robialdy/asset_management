<?php
// ADMIN

use App\Models\Asset;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetOwnershipController;
use App\Http\Controllers\Admin\UsersController;
// USERS

use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// Route::get('admin', function () {
//     return view('admin.dashboard.index');
// });

// AUTH
Route::prefix('auth')->group(function(){
    Route::get('', [AuthController::class, 'index'])->name('auth');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// USER
Route::middleware(['auth', 'role:User'])->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('user');
});

// ADMIN
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('', [AdminDashboardController::class, 'index'])->name('admin');

        // USER - ACCOUNT
        Route::prefix('user-account')->group(function () {
            Route::get('', [UsersController::class, 'userView'])->name('admin.user.view');
            // CREATE
            Route::get('create', [UsersController::class, 'userCreate'])->name('admin.user.create');
            Route::post('store', [UsersController::class, 'userStore'])->name('admin.user.store');
            // EDIT
            Route::get('edit/{username}', [UsersController::class, 'userEdit'])->name('admin.user.edit');
            Route::put('edit/{username}', [UsersController::class, 'userUpdate'])->name('admin.user.update');
            // DELETE
            Route::delete('delete/{id}', [UsersController::class, 'userDelete'])->name('admin.user.delete');
        });
        // RESET PASSWORD
        Route::post('reset-password/{id}', [UsersController::class, 'resetPassword'])->name('admin.reset-password');

        // ADMIN - ACCOUNT
        Route::prefix('admin-account')->group(function () {
            Route::get('', [UsersController::class, 'adminView'])->name('admin.view');
            // CREATE
            Route::get('create', [UsersController::class, 'adminCreate'])->name('admin.create');
            Route::post('store', [UsersController::class, 'adminStore'])->name('admin.store');
            // EDIT
            Route::get('edit/{username}', [UsersController::class, 'adminEdit'])->name('admin.edit');
            Route::put('edit/{username}', [UsersController::class, 'adminUpdate'])->name('admin.update');
            // DELETE
            Route::delete('delete/{id}', [UsersController::class, 'adminDelete'])->name('admin.delete');
        });

        // ASSETS
        Route::prefix('available-asset')->group(function () {
            Route::get('', [AssetController::class, 'index'])->name('assets');
            // CREATE
            Route::get('create', [AssetController::class, 'create'])->name('asset.create');
            Route::post('create', [AssetController::class, 'store'])->name('asset.store');
            // EDIT
            Route::get('edit/{slug}', [AssetController::class, 'edit'])->name('asset.edit');
            Route::put('edit/{id}', [AssetController::class, 'update'])->name('asset.update');
            // MODAL DETAIL
            Route::get('detail/{slug}', [AssetController::class, 'detail'])->name('asset.detail');
        });

        // OFFICE
        Route::prefix('office')->group(function() {
            Route::get('', [OfficeController::class, 'index'])->name('office');
            // CREATE
            Route::get('create', [OfficeController::class, 'create'])->name('office.create');
            Route::post('create', [OfficeController::class, 'store'])->name('office.store');
            // EDIT
            Route::get('edit/{slug}', [OfficeController::class, 'edit'])->name('office.edit');
            Route::put('edit/{id}', [OfficeController::class, 'update'])->name('office.update');
        });

        // ASSET OWNERSHIP
        Route::prefix('asset-ownership')->group(function() {
            Route::get('', [AssetOwnershipController::class, 'index'])->name('asset-ownership');
            // CREATE
            Route::get('add', [AssetOwnershipController::class, 'create'])->name('asset-ownership.create');
            Route::post('add', [AssetOwnershipController::class, 'store'])->name('asset-ownership.store');
            // DETAIL
            Route::get('detail/{name}/{item}', [AssetOwnershipController::class, 'detail'])->name('asset-ownership.detail');
            // EDIT (KE EDIT ASSET CUMA MODIF URL AJA)
            Route::get('edit/{slug}', [AssetController::class, 'edit'])->name('asset.edit.ownership');
        });
    });
});

