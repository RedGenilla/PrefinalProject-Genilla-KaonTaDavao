<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EateryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\ReviewController;

// Home page.
Route::get('/', HomeController::class)->name('home');

// All seven eatery resource routes.
Route::resource('eateries', EateryController::class);

// Add and delete reviews.
Route::post(
    '/eateries/{eatery}/reviews',
    [ReviewController::class, 'store']
)->name('eateries.reviews.store');

Route::delete(
    '/reviews/{review}',
    [ReviewController::class, 'destroy']
)->name('reviews.destroy');

// District pages.
Route::get(
    '/districts',
    [DistrictController::class, 'index']
)->name('districts.index');

Route::get(
    '/districts/{district}',
    [DistrictController::class, 'show']
)->name('districts.show');

// Reviewer profile page.
Route::get(
    '/reviewers/{user}',
    [ReviewerController::class, 'show']
)->name('reviewers.show');

