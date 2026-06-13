<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KeTemuController;
use App\Http\Controllers\SearchController;

Route::get('/', fn() => auth()->check() ? redirect()->route('dashboard') : view('welcome'))->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/register',             [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',            [AuthController::class, 'register']);
    Route::get('/login',                [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',               [AuthController::class, 'login']);
    Route::get('/auth/google',          [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/pilih-mode',  [AuthController::class, 'showPilihMode'])->name('pilih.mode');
    Route::post('/pilih-mode', [AuthController::class, 'setPilihMode'])->name('pilih.mode.set');

    Route::get('/dashboard',   [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/lokal',       [DashboardController::class, 'lokal'])->name('lokal');

    // Search
    Route::get('/search',      [SearchController::class, 'index'])->name('search');

    Route::get('/post/create',          [PostController::class, 'create'])->name('post.create');
    Route::post('/post',                [PostController::class, 'store'])->name('post.store');
    Route::get('/post/{post}',          [PostController::class, 'show'])->name('post.show');
    Route::delete('/post/{post}',       [PostController::class, 'destroy'])->name('post.destroy');
    Route::post('/post/{post}/repost',  [PostController::class, 'repost'])->name('post.repost');

    Route::post('/post/{post}/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    Route::post('/post/{post}/like',    [LikeController::class, 'toggle'])->name('like.toggle');
    Route::post('/follow/{user}',       [FollowController::class, 'toggle'])->name('follow.toggle');

    Route::get('/u/{user:username}',    [ProfileController::class, 'show'])->name('profil');
    Route::get('/u/{user:username}/followers', [ProfileController::class, 'followers'])->name('profil.followers');
    Route::get('/u/{user:username}/following', [ProfileController::class, 'following'])->name('profil.following');
    Route::get('/settings/profile',     [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/settings/profile',    [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/settings/mode',       [ProfileController::class, 'updateMode'])->name('profile.mode');

    Route::get('/hidden-gem',            [LocationController::class, 'index'])->name('lokasi.index');
    Route::get('/hidden-gem/tambah',     [LocationController::class, 'create'])->name('lokasi.create');
    Route::post('/hidden-gem',           [LocationController::class, 'store'])->name('lokasi.store');
    Route::get('/hidden-gem/{location}', [LocationController::class, 'show'])->name('lokasi.show');

    Route::get('/pesan',            [MessageController::class, 'index'])->name('pesan.index');
    Route::get('/pesan/cari',       [MessageController::class, 'searchUser'])->name('pesan.search');
    Route::get('/pesan/{user}',     [MessageController::class, 'show'])->name('pesan.show');
    Route::post('/pesan/{user}',    [MessageController::class, 'send'])->name('pesan.send');

    Route::get('/ketemu',                  [KeTemuController::class, 'index'])->name('ketemu.index');
    Route::post('/ketemu/check-in',        [KeTemuController::class, 'checkIn'])->name('ketemu.checkin');
    Route::post('/ketemu/request/{user}',  [KeTemuController::class, 'request'])->name('ketemu.request');
    Route::post('/ketemu/respond/{meetup}',[KeTemuController::class, 'respond'])->name('ketemu.respond');
    Route::get('/ketemu/nearby',           [KeTemuController::class, 'nearby'])->name('ketemu.nearby');
});
