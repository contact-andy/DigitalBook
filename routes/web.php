<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessageCategoryController;
use App\Http\Controllers\MessageTemplateController;
use App\Http\Controllers\ResponseTemplateController;
use App\Http\Controllers\PublishMessageController;
use App\Http\Controllers\MessageApprovalController;

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

use App\Http\Controllers\MessageTemplateApprovalController;
use App\Http\Controllers\ResponseTemplateApprovalController;


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
    
    Route::resource('event-categories', EventCategoryController::class)->middleware('application.permission');
    Route::resource('academic-calendars', AcademicCalendarController::class)->middleware('application.permission');
    Route::resource('publish-calendars', PublishCalendarController::class)->middleware('application.permission');
    Route::post('/after-campus-selection', [AcademicCalendarController::class, 'afterCampusSelection'])->name('after-campus-selection');

    Route::resource('surveys', SurveyController::class)->middleware('application.permission');
    Route::resource('survey-questions', SurveyQuestionController::class)->middleware('application.permission');
    Route::resource('publish-survey', PublishSurveyController::class)->middleware('application.permission');

    Route::resource('application-grant', ApplicationGrantController::class)->middleware('application.permission');
    Route::resource('data-grants', DataGrantController::class)->middleware('application.permission');
    Route::resource('user-activities', UserActivityController::class)->middleware('application.permission');
    Route::post('/after-user-selection', [ApplicationGrantController::class, 'afterUserSelection'])->name('after-user-selection');


    Route::resource('analytical-report', AnalyticalReportController::class)->middleware('application.permission');
    Route::resource('message-report', MessageReportController::class)->middleware('application.permission');
    Route::resource('survey-responses', SurveyResponseReportController::class)->middleware('application.permission');

    Route::resource('dashboard-setting', DashboardSettingController::class)->middleware('application.permission');
    Route::resource('message-setting', MessageSettingController::class)->middleware('application.permission');

    //APPROVAL
    Route::get('category-approval', [MessageCategoryController::class, 'categoryApproval'])->name('category-approval.index')->middleware('application.permission');
    Route::put('category-approval', [MessageCategoryController::class, 'approve'])->name('category-approval.approve')->middleware('application.permission');
    Route::post('/category-approval/instantApprove', [MessageCategoryController::class, 'instantApprove'])->name('category-approval.instantApprove');

    Route::get('event-approval', [EventCategoryController::class, 'eventApproval'])->name('event-approval.index')->middleware('application.permission');
    Route::put('event-approval', [EventCategoryController::class, 'approve'])->name('event-approval.approve')->middleware('application.permission');
    Route::post('/event-approval/instantApprove', [EventCategoryController::class, 'instantApprove'])->name('event-approval.instantApprove');

    Route::resource('message-approval', MessageApprovalController::class)->middleware('application.permission');
    
    Route::get('message-templates-approval', [MessageTemplateApprovalController::class, 'index'])->name('message-templates-approval.index')->middleware('application.permission');
    Route::put('message-templates-approval', [MessageTemplateApprovalController::class, 'approve'])->name('message-templates-approval.approve')->middleware('application.permission');
    Route::post('/template-approval/instantApprove', [MessageTemplateApprovalController::class, 'instantApprove'])->name('template-approval.instantApprove');

    Route::get('response-templates-approval', [ResponseTemplateApprovalController::class, 'index'])->name('response-templates-approval.index')->middleware('application.permission');
    Route::put('response-templates-approval', [ResponseTemplateApprovalController::class, 'approve'])->name('response-templates-approval.approve')->middleware('application.permission');
    Route::post('/response-approval/instantApprove', [ResponseTemplateApprovalController::class, 'instantApprove'])->name('response-approval.instantApprove');

    // Route::get('/category-approval/instantApprove/{id}', [MessageCategoryController::class, 'instantApprove'])->name('category-approval.instantApprove');

});


require __DIR__.'/auth.php';
