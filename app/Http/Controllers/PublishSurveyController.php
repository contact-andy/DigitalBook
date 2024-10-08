<?php

namespace App\Http\Controllers;

use App\Models\PublishSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;


class PublishSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $routeName='publish-survey';
        $hasPermission = DB::table('dcb_application_permissions')
        ->join('dcb_application_lists', 'dcb_application_lists.id', '=', 'dcb_application_permissions.appId')
        ->where('userId', $user->id)
        ->where('dcb_application_lists.url', $routeName)
        ->exists();
        return $hasPermission;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PublishSurvey $publishSurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublishSurvey $publishSurvey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublishSurvey $publishSurvey)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublishSurvey $publishSurvey)
    {
        //
    }
}
