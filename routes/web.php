<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

use App\Http\Controllers\Auth\GoogleController;
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

use App\Http\Controllers\Auth\FacebookController;
Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.login');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

use App\Http\Controllers\Auth\LinkedInController;
Route::get('login/linkedin', [LinkedInController::class, 'redirectToLinkedIn'])->name('linkedin.login');
Route::get('login/linkedin/callback', [LinkedInController::class, 'handleLinkedInCallback']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('template', 'Template')->name('template');
});

use App\Http\Controllers\ComplaintController;
Route::middleware('auth')->group(function () {
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint.index');
    Route::get('/complaint/create', [ComplaintController::class, 'create'])->name('complaint.create');
    Route::post('/complaint/post', [ComplaintController::class, 'store'])->name('complaint.post');
    Route::get('/complaint/{complaint}/edit', [ComplaintController::class, 'edit'])->name('complaint.edit');
    Route::post('/complaint/{complaint}/update', [ComplaintController::class, 'update'])->name('complaint.update');
    Route::get('/complaint/{complaint}/show', [ComplaintController::class, 'show'])->name('complaint.show');
});

use App\Http\Controllers\MapController;
Route::middleware('auth')->group(function () {
    Route::get('/map', [MapController::class, 'index'])->name('map.index');
});

use App\Http\Controllers\CustomerController;
Route::middleware('auth')->group(function () {
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/customer/post', [CustomerController::class, 'store'])->name('customer.post');
    Route::get('/customer/{customer}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('/customer/{customer}/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::post('/customer/{customer}/update_ajax', [CustomerController::class, 'update_ajax'])->name('customer.update_ajax');
    Route::get('/customer/{customer}/show', [CustomerController::class, 'show'])->name('customer.show');
});

use App\Http\Controllers\FaceRecognitionController;
Route::middleware('auth')->group(function () {
    Route::get('/face_recognition', [FaceRecognitionController::class, 'index'])->name('face_recognition.index');
});

use App\Http\Controllers\ChatController;
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/automation', [ChatController::class, 'index_automation'])->name('chat.index_automation');
});

use App\Http\Controllers\ChatbotController;
Route::middleware('auth')->group(function () {
    Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::get('/chatbot/create', [ChatbotController::class, 'create'])->name('chatbot.create');
    Route::get('/chatbot/{chatbot}/show', [ChatbotController::class, 'show'])->name('chatbot.show');
    Route::get('/chatbot/{chatbot}/edit', [ChatbotController::class, 'edit'])->name('chatbot.edit');
    Route::post('/chatbot/post1', [ChatbotController::class, 'store1'])->name('chatbot.post1');
    Route::post('/chatbot/post2', [ChatbotController::class, 'store2'])->name('chatbot.post2');
    Route::post('/chatbot/{chatbot}/update', [ChatbotController::class, 'update'])->name('chatbot.update');
    Route::post('/chatbot/send_to_ai1', [ChatbotController::class, 'send_to_ai1'])->name('chatbot.send_to_ai1');
    Route::post('/chatbot/{chatbot}/send_to_ai2', [ChatbotController::class, 'send_to_ai2'])->name('chatbot.send_to_ai2');
    Route::post('/chatbot/send_to_ai3', [ChatbotController::class, 'send_to_ai3'])->name('chatbot.send_to_ai3');
});

require __DIR__ . '/settings.php';
