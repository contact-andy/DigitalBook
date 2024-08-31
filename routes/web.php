<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageCategoryController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\ResponseTemplateController;
use App\Http\Controllers\AcademicCalendarController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth/login');
});

Route::get('/', function () {
    return view('dashboard');  // Home page view
})->middleware('auth');  // Ensure only authenticated users can access this route

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::resource('message-categories', MessageCategoryController::class);
    Route::patch('message-categories/{id}/restore', [MessageCategoryController::class, 'restore'])->name('message-categories.restore');
    Route::delete('message-categories/{id}/forceDelete', [MessageCategoryController::class, 'forceDelete'])->name('message-categories.forceDelete');
    Route::resource('message-templates', MessageTemplateController::class);
    Route::resource('response-templates', ResponseTemplateController::class);
    Route::resource('academic-calendars', AcademicCalendarController::class);
    Route::resource('surveys', SurveyController::class);
    Route::resource('survey-questions', SurveyQuestionController::class);


});


require __DIR__.'/auth.php';
