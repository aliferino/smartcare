<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Import Controller Web
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CampaignController;

// Import Controller Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KycController as AdminKycController;
use App\Http\Controllers\Admin\CampaignController as AdminCampaignController;
use App\Http\Controllers\Admin\EntityController as AdminEntityController;
use App\Http\Controllers\Admin\EntityCategoryController;
use App\Http\Controllers\Admin\CampaignCategoryController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CitizenController as AdminCitizenController;
use App\Http\Controllers\Admin\BroadcastController;
use App\Http\Controllers\Admin\ChatController as AdminChatController;

// Import Controller Fundraiser
use App\Http\Controllers\Fundraiser\ProfileController;
use App\Http\Controllers\Fundraiser\DashboardController as FundraiserDashboardController;
use App\Http\Controllers\Fundraiser\CampaignController as FundraiserCampaignController;
use App\Http\Controllers\Fundraiser\EntityController as FundraiserEntityController;
use App\Http\Controllers\Fundraiser\CitizenController as FundraiserCitizenController;
use App\Http\Controllers\Fundraiser\DonationController as FundraiserDonationController;
use App\Http\Controllers\Fundraiser\InboxController;
use App\Http\Controllers\Fundraiser\ChatController as FundraiserChatController;

// Public Web Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns');
Route::get('/campaigns/{slug}', [CampaignController::class, 'show'])->name('campaign.detail');

// Donation Routes
Route::post('/donation/store', [CampaignController::class, 'storeDonation'])->name('donation.store');
Route::put('/api/donations/{donation}/update-status', [CampaignController::class, 'updateDonationStatus'])->name('donation.update-status');

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

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

        // Entity Management
        Route::prefix('entities')->name('entities.')->group(function () {
            Route::get('/categories', [EntityCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories/store', [EntityCategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}/update', [EntityCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}/delete', [EntityCategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('/list', [AdminEntityController::class, 'index'])->name('index');
            Route::get('/list/pending', [AdminEntityController::class, 'pending'])->name('pending');
            Route::get('/list/approved', [AdminEntityController::class, 'approved'])->name('approved');
            Route::get('/list/rejected', [AdminEntityController::class, 'rejected'])->name('rejected');
            Route::get('/list/{id}/detail', [AdminEntityController::class, 'detail'])->name('detail');
            Route::post('/list/{id}/update-status', [AdminEntityController::class, 'updateStatus'])->name('update-status');
            Route::post('/list/{id}/toggle-active', [AdminEntityController::class, 'toggleActive'])->name('toggle-active');
        });

        // Campaign Management
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/categories', [CampaignCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories/store', [CampaignCategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}/update', [CampaignCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}/delete', [CampaignCategoryController::class, 'destroy'])->name('categories.destroy');
            Route::get('/list', [AdminCampaignController::class, 'index'])->name('index');
            Route::get('/list/pending', [AdminCampaignController::class, 'pending'])->name('pending');
            Route::get('/list/approved', [AdminCampaignController::class, 'approved'])->name('approved');
            Route::get('/list/rejected', [AdminCampaignController::class, 'rejected'])->name('rejected');
            Route::get('/list/completed', [AdminCampaignController::class, 'completed'])->name('completed');
            Route::get('/list/{id}/detail', [AdminCampaignController::class, 'detail'])->name('detail');
            Route::post('/list/{id}/update-status', [AdminCampaignController::class, 'updateStatus'])->name('update-status');
            Route::post('/list/{id}/toggle-active', [AdminCampaignController::class, 'toggleActive'])->name('toggle-active');
        });

        Route::prefix('donations')->name('donations.')->group(function () {
            Route::get('/', [DonationController::class, 'index'])->name('index');
        });

        // User Management
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/list', [UserController::class, 'index'])->name('index');
            Route::get('/list/{id}/detail', [UserController::class, 'detail'])->name('detail');
            Route::post('/create', [UserController::class, 'create'])->name('create');
            Route::put('/{user}/update', [UserController::class, 'update'])->name('update');
            Route::delete('/{user}/delete', [UserController::class, 'destroy'])->name('destroy');
            Route::get('/citizens', [AdminCitizenController::class, 'index'])->name('citizens.index');
            Route::get('/citizens/pending', [AdminCitizenController::class, 'pending'])->name('citizens.pending');
            Route::get('/citizens/approved', [AdminCitizenController::class, 'approved'])->name('citizens.approved');
            Route::get('/citizens/rejected', [AdminCitizenController::class, 'rejected'])->name('citizens.rejected');
            Route::get('/citizens/{id}/detail', [AdminCitizenController::class, 'detail'])->name('citizens.detail');
            Route::post('/citizens/{id}/update', [AdminCitizenController::class, 'updateStatus'])->name('citizens.update');
        });

        // Broadcasts
        Route::prefix('broadcasts')->name('broadcasts.')->group(function () {
            Route::get('/', [BroadcastController::class, 'index'])->name('index');
            Route::get('/create', [BroadcastController::class, 'create'])->name('create');
            Route::post('/store', [BroadcastController::class, 'store'])->name('store');
        });

        // Chats
        Route::prefix('chats')->name('chats.')->group(function () {
            Route::get('/', [AdminChatController::class, 'index'])->name('index');
            Route::get('/{userId}', [AdminChatController::class, 'show'])->name('show');
            Route::post('/store', [AdminChatController::class, 'store'])->name('store');
        });

    });

    // --- FUNDRAISER AREA ---
    Route::middleware(['auth', 'role:fundraiser', 'fundraiser.status'])->prefix('fundraiser')->name('fundraiser.')->group(function () {
        Route::get('/dashboard', [FundraiserDashboardController::class, 'index'])->name('index');

        // --- CITIZEN/KYC MANAGEMENT ---
        Route::prefix('citizen')->name('citizen.')->group(function () {
            Route::get('/', [FundraiserCitizenController::class, 'index'])->name('index');
            Route::post('/store', [FundraiserCitizenController::class, 'store'])->name('store');
            Route::put('/update', [FundraiserCitizenController::class, 'update'])->name('update');
        });

        // --- ENTITY MANAGEMENT (PENAMBAHAN BARU) ---
        Route::prefix('entities')->name('entities.')->group(function () {
            Route::get('/', [FundraiserEntityController::class, 'index'])->name('index');
            Route::get('/create', [FundraiserEntityController::class, 'create'])->name('create');
            Route::post('/store', [FundraiserEntityController::class, 'store'])->name('store');
            Route::get('/{entity}/detail', [FundraiserEntityController::class, 'detail'])->name('detail');
            Route::get('/{entity}/edit', [FundraiserEntityController::class, 'edit'])->name('edit');
            Route::put('/{entity}/update', [FundraiserEntityController::class, 'update'])->name('update');
            Route::delete('/{entity}/destroy', [FundraiserEntityController::class, 'destroy'])->name('destroy');
            });
            
            // --- CAMPAIGN MANAGEMENT ---
        Route::prefix('campaigns')->name('campaigns.')->group(function () {
            Route::get('/', [FundraiserCampaignController::class, 'index'])->name('index');
            Route::get('/create', [FundraiserCampaignController::class, 'create'])->name('create');
            Route::post('/store', [FundraiserCampaignController::class, 'store'])->name('store');
            Route::get('/{campaign}/detail', [FundraiserCampaignController::class, 'detail'])->name('detail');
            Route::get('/{campaign}/edit', [FundraiserCampaignController::class, 'edit'])->name('edit');
            Route::put('/{campaign}/update', [FundraiserCampaignController::class, 'update'])->name('update');
            Route::delete('/{campaign}/destroy', [FundraiserCampaignController::class, 'destroy'])->name('destroy');
        });

        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

        // Finance & Reports
        Route::get('/donations', [FundraiserDonationController::class, 'index'])->name('donations');

        // Inbox (Broadcasts from Admin)
        Route::prefix('inbox')->name('inbox.')->group(function () {
            Route::get('/', [InboxController::class, 'index'])->name('index');
            Route::get('/{id}', [InboxController::class, 'show'])->name('show');
        });

        // Chats
        Route::prefix('chats')->name('chats.')->group(function () {
            Route::get('/', [FundraiserChatController::class, 'index'])->name('index');
            Route::post('/store', [FundraiserChatController::class, 'store'])->name('store');
        });

        Route::get('/withdraw', function () {
            $withdraws = Withdraw::whereHas('campaign', fn($q) => $q->where('user_id', Auth::id()))
                ->with('campaign')->latest()->get();
            return view('fundraiser.withdraw', compact('withdraws'));
        })->name('withdraw');
    });
});