<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageCategoryController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\ResponseTemplateController;
use App\Http\Controllers\PublishMessageController;
use App\Http\Controllers\MessageApprovalController;

use App\Http\Controllers\AcademicCalendarController;
use App\Http\Controllers\PublishCalendarController;

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\PublishSurveyController;

use App\Http\Controllers\PermissionGrantController;
use App\Http\Controllers\UserActivityController;

use App\Http\Controllers\AnalyticalReportController;
use App\Http\Controllers\MessageReportController;
use App\Http\Controllers\SurveyResponseReportController;

use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\MessageSettingController;


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
    Route::patch('message-categories/{id}/restore', [MessageCategoryController::class, 'restore'])->name('message-categories.restore');
    Route::delete('message-categories/{id}/forceDelete', [MessageCategoryController::class, 'forceDelete'])->name('message-categories.forceDelete');
    
    Route::resource('message-categories', MessageCategoryController::class);
    Route::resource('message-templates', MessageTemplateController::class);
    Route::resource('response-templates', ResponseTemplateController::class);
    Route::resource('publish-messages', PublishMessageController::class);
    Route::resource('message-approval', PublishMessageController::class);

    Route::resource('academic-calendars', AcademicCalendarController::class);
    Route::resource('publish-calendars', PublishCalendarController::class);

    Route::resource('surveys', SurveyController::class);
    Route::resource('survey-questions', SurveyQuestionController::class);
    Route::resource('publish-survey', PublishSurveyController::class);

    Route::resource('permission-grant', PermissionGrantController::class);
    Route::resource('user-activities', UserActivityController::class);

    Route::resource('analytical-report', AnalyticalReportController::class);
    Route::resource('message-report', MessageReportController::class);
    Route::resource('survey-responses', SurveyResponseReportController::class);

    Route::resource('dashboard-setting', DashboardSettingController::class);
    Route::resource('message-setting', MessageSettingController::class);
});


require __DIR__.'/auth.php';
