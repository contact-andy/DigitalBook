<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageCategoryController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\ResponseTemplateController;
use App\Http\Controllers\PublishMessageController;
use App\Http\Controllers\MessageApprovalController;
use App\Http\Controllers\TemplateApprovalController;

use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\AcademicCalendarController;
use App\Http\Controllers\PublishCalendarController;

use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyQuestionController;
use App\Http\Controllers\PublishSurveyController;

use App\Http\Controllers\ApplicationGrantController;
use App\Http\Controllers\DataGrantController;
use App\Http\Controllers\UserActivityController;

use App\Http\Controllers\AnalyticalReportController;
use App\Http\Controllers\MessageReportController;
use App\Http\Controllers\SurveyResponseReportController;

use App\Http\Controllers\DashboardSettingController;
use App\Http\Controllers\MessageSettingController;
use App\Http\Middleware\CheckApplicationPermission;

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
    
    Route::resource('message-categories', MessageCategoryController::class)->middleware('application.permission');
    Route::resource('message-templates', MessageTemplateController::class)->middleware('application.permission');
    Route::resource('response-templates', ResponseTemplateController::class)->middleware('application.permission');
    Route::resource('publish-messages', PublishMessageController::class)->middleware('application.permission');
    Route::resource('message-approval', MessageApprovalController::class)->middleware('application.permission');
    Route::resource('template-approval', TemplateApprovalController::class)->middleware('application.permission');

    Route::resource('event-categories', EventCategoryController::class)->middleware('application.permission');
    Route::resource('academic-calendars', AcademicCalendarController::class)->middleware('application.permission');
    Route::resource('publish-calendars', PublishCalendarController::class)->middleware('application.permission');

    Route::resource('surveys', SurveyController::class)->middleware('application.permission');
    Route::resource('survey-questions', SurveyQuestionController::class)->middleware('application.permission');
    Route::resource('publish-survey', PublishSurveyController::class)->middleware('application.permission');

    Route::resource('application-grant', ApplicationGrantController::class)->middleware('application.permission');
    Route::resource('data-grant', DataGrantController::class)->middleware('application.permission');
    Route::resource('user-activities', UserActivityController::class)->middleware('application.permission');
    Route::post('/after-user-selection', [ApplicationGrantController::class, 'afterUserSelection'])->name('after-user-selection');


    Route::resource('analytical-report', AnalyticalReportController::class)->middleware('application.permission');
    Route::resource('message-report', MessageReportController::class)->middleware('application.permission');
    Route::resource('survey-responses', SurveyResponseReportController::class)->middleware('application.permission');

    Route::resource('dashboard-setting', DashboardSettingController::class)->middleware('application.permission');
    Route::resource('message-setting', MessageSettingController::class)->middleware('application.permission');
});


require __DIR__.'/auth.php';
