<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Withdraw;
use App\Models\Entity;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
// Import Controller Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KycController as AdminKycController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\EntityController as AdminEntityController;
use App\Http\Controllers\Admin\EntityCategoryController;
use App\Http\Controllers\Admin\CampaignCategoryController;
// Import Controller Fundraiser
use App\Http\Controllers\Fundraiser\ProfileController;
use App\Http\Controllers\Fundraiser\KycController as FundraiserKycController;
use App\Http\Controllers\Fundraiser\CampaignController as FundraiserCampaignController;
use App\Http\Controllers\Fundraiser\EntityController as FundraiserEntityController; // Tambahkan ini

// Auth Guest
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Main App
Route::middleware('auth')->group(function () {

    // --- ADMIN AREA ---
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.index');
        })->name('index');

        // Entity Management
        Route::prefix('entities')->name('entities.')->group(function () {
            Route::get('/categories', [EntityCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories/store', [EntityCategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}/update', [EntityCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}/delete', [EntityCategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('/', [AdminEntityController::class, 'index'])->name('index'); // Untuk Approval
            Route::get('/list', [AdminEntityController::class, 'list'])->name('list'); // Riwayat
            Route::get('/{id}/detail', [AdminEntityController::class, 'detail'])->name('detail');
            Route::patch('/{id}/approve', [AdminEntityController::class, 'approve'])->name('approve'); // Proses ACC
            Route::patch('/{id}/reject', [AdminEntityController::class, 'reject'])->name('reject'); // Proses Tolak
        });

        // Campaign Management
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/categories', [CampaignCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories/store', [CampaignCategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}/update', [CampaignCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}/delete', [CampaignCategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('/', [AdminCampaignController::class, 'index'])->name('index');
            Route::get('/list', [AdminCampaignController::class, 'list'])->name('list');
            Route::get('/{id}/detail', [AdminCampaignController::class, 'detail'])->name('detail');
            Route::patch('/{id}/approve', [AdminCampaignController::class, 'approve'])->name('approve');
            Route::patch('/{id}/reject', [AdminCampaignController::class, 'reject'])->name('reject'); // Tambah reject
        });

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/create', [UserController::class, 'create'])->name('create');
            Route::put('/{user}/update', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}/delete', [UserController::class, 'destroy'])->name('destroy');

            Route::get('/kyc/verif', [AdminKycController::class, 'index'])->name('kyc.verif');
            Route::get('/kyc/list', [AdminKycController::class, 'list'])->name('kyc.list');
            Route::get('/kyc/{id}/detail', [AdminKycController::class, 'detail'])->name('kyc.detail');
            Route::patch('/kyc/{id}/approve', [AdminKycController::class, 'approve'])->name('kyc.approve');
            Route::patch('/kyc/{id}/reject', [AdminKycController::class, 'reject'])->name('kyc.reject');
        });

    });

    // --- FUNDRAISER AREA ---
    Route::middleware(['auth', 'role:fundraiser'])->prefix('fundraiser')->name('fundraiser.')->group(function () {
        Route::get('/dashboard', function () {
            return view('fundraiser.index');
        })->name('index');

        // --- ENTITY MANAGEMENT (PENAMBAHAN BARU) ---
        Route::prefix('entities')->name('entities.')->group(function () {
            Route::get('/', [FundraiserEntityController::class, 'index'])->name('index');
            Route::get('/create', [FundraiserEntityController::class, 'create'])->name('create');
            Route::post('/store', [FundraiserEntityController::class, 'store'])->name('store');
            Route::get('/{entity}/edit', [FundraiserEntityController::class, 'edit'])->name('edit');
            Route::put('/{entity}/update', [FundraiserEntityController::class, 'update'])->name('update');
            Route::delete('/{entity}/destroy', [FundraiserEntityController::class, 'destroy'])->name('destroy');
            });
            
            // --- CAMPAIGN MANAGEMENT ---
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', [FundraiserCampaignController::class, 'index'])->name('index');
            Route::get('/create', [FundraiserCampaignController::class, 'create'])->name('create');
            Route::post('/store', [FundraiserCampaignController::class, 'store'])->name('store');
            Route::get('/{campaign}/edit', [FundraiserCampaignController::class, 'edit'])->name('edit');
            Route::put('/{campaign}/update', [FundraiserCampaignController::class, 'update'])->name('update');
            Route::delete('/{campaign}/destroy', [FundraiserCampaignController::class, 'destroy'])->name('destroy');
        });

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Finance & Reports
        Route::get('/donations', function () {
            $donations = Donation::whereHas('campaign', fn($q) => $q->where('user_id', Auth::id()))
                ->with('campaign')->latest()->get();
            return view('fundraiser.donationList', compact('donations'));
        })->name('donations');

        Route::get('/withdraw', function () {
            $withdraws = Withdraw::whereHas('campaign', fn($q) => $q->where('user_id', Auth::id()))
                ->with('campaign')->latest()->get();
            return view('fundraiser.withdraw', compact('withdraws'));
        })->name('withdraw');

        // KYC Verification Submit
        Route::get('/kyc', [FundraiserKycController::class, 'showKycForm'])->name('kyc.form');
        Route::post('/kyc-submit', [FundraiserKycController::class, 'submitKyc'])->name('kyc.submit');
    });
});