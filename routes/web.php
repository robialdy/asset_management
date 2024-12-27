<?php
// ADMIN

use App\Http\Controllers\Admin\OfficeOwnershipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AssetController;
use App\Http\Controllers\Admin\AssetOwnershipController;
use App\Http\Controllers\Admin\UsersController;

use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\admin\RejuvenationRecommendationController as RejuvenationAdmin;
use App\Http\Controllers\user\RejuvenationRecommendationController as RejuvenationUser;
use App\Http\Controllers\admin\SubmissionRecommendationController as SubmissionAdmin;
use App\Http\Controllers\user\SubmissionRecommendationController as SubmissionUser;

// AUTH
Route::prefix('auth')->group(function(){
    Route::get('', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// USER
Route::middleware(['auth', 'role:User'])->group(function () {
    Route::get('/', [UserDashboardController::class, 'index'])->name('user');

    // REKOMENDASI PENGAJUAN
    Route::prefix('submission-recommendation')->group(function(){
        Route::get('', [SubmissionUser::class, 'index'])->name('submission-recommendation');
        // REQUEST (CREATE)
        Route::get('request', [SubmissionUser::class, 'create'])->name('submission-recommendation.create');
        Route::post('request', [SubmissionUser::class, 'store'])->name('submission-recommendation.store');
        // MODAL
        Route::post('modal', [SubmissionUser::class, 'modal'])->name('submission-recommendation.modal');
        // ATTACHMENT
        Route::get('attachment/{slug}', [SubmissionUser::class, 'attachment'])->name('submission-recommendation.attachment');
    });

    // REKOMENDASI PEREMAJAAN
    Route::prefix('rejuvenation-recommendation')->group(function(){
        Route::get('', [RejuvenationUser::class, 'index'])->name('rejuvenation-recommendation');
        // CREATE
        Route::get('request', [RejuvenationUser::class, 'create'])->name('rejuvenation-recommendation.create');
        Route::post('request', [RejuvenationUser::class, 'store'])->name('rejuvenation-recommendation.store');
        // MODAL
        Route::post('modal', [RejuvenationUser::class, 'modal'])->name('rejuvenation-recommendation.modal');
    });
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
            // DETAIL
            Route::get('detail/{slug}', [AssetController::class, 'detail'])->name('asset.detail');
        });
        Route::prefix('asset/destroy')->group(function() {
            Route::get('', [AssetController::class, 'destroy'])->name('asset.destroy');
            // DETAIL
            Route::get('detail/{slug}', [AssetController::class, 'detail'])->name('asset.destroy.detail');
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

        // OFFICE OWNERSHIP
        Route::prefix('office-ownership')->group(function() {
            Route::get('', [OfficeOwnershipController::class, 'index'])->name('office-ownership');
            //CREATE
            Route::get('create', [OfficeOwnershipController::class, 'create'])->name('office-ownership.create');
            Route::post('create', [OfficeOwnershipController::class, 'store'])->name('office-ownership.store');
            // DETAIL
            Route::get('detail/{slugOffice}/{slugAsset}', [OfficeOwnershipController::class, 'detail'])->name('office-ownership.detail');
            // EDIT
            Route::get('edit/{slug}', [AssetController::class, 'edit'])->name('office-ownership.edit');
            // UPDATE STATUS DESTROY
            Route::post('destroy/{id}', [OfficeOwnershipController::class, 'destroy'])->name('office-ownership.destroy');
        });

        // ASSET OWNERSHIP
        Route::prefix('asset-ownership')->group(function() {
            Route::get('', [AssetOwnershipController::class, 'index'])->name('asset-ownership');
            // CREATE
            Route::get('add', [AssetOwnershipController::class, 'create'])->name('asset-ownership.create');
            Route::post('add', [AssetOwnershipController::class, 'store'])->name('asset-ownership.store');
            // DETAIL
            Route::get('detail/{slugName}/{slugAsset}', [AssetOwnershipController::class, 'detail'])->name('asset-ownership.detail');
            // EDIT (KE EDIT ASSET CUMA MODIF URL AJA)
            Route::get('edit/{slug}', [AssetController::class, 'edit'])->name('asset.edit.ownership');
            // UPDATE STATUS DESTROY
            Route::post('destroy/{id}', [AssetOwnershipController::class, 'destroy'])->name('asset-ownership.destroy');
        });

        // REQUEST PENGAJUAN
        Route::prefix('submission-request')->group(function(){
            Route::get('', [SubmissionAdmin::class, 'index'])->name('submission-request');
            // MODAL
            Route::post('modal', [SubmissionAdmin::class, 'modal'])->name('submission-request.modal');
            // REPLY
            Route::put('confirm/{id}', [SubmissionAdmin::class, 'reply'])->name('submission-request.reply');
            // COMPLETED
            Route::put('completed/{id}', [SubmissionAdmin::class, 'completed'])->name('submission-request.completed');
        });

        // REQUEST PEREMAJAAN
        Route::prefix('rejuvenation-request')->group(function(){
            Route::get('', [RejuvenationAdmin::class, 'index'])->name('rejuvenation-request');
            // MODAL
            Route::post('modal', [RejuvenationAdmin::class, 'modal'])->name('rejuvenation-request.modal');
            // REPLY
            Route::put('confirm/{id}', [RejuvenationAdmin::class, 'reply'])->name('rejuvenation-request.reply');
        });

    });
});

