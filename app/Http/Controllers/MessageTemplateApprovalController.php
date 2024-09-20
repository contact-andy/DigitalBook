<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplateApproval;
use App\Models\MessageTemplate;
use App\Models\MessageCategory;
use App\Models\GradeLevel;
use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MessageTemplateApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'message-template-approval'; $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();
        $templates = MessageTemplate::select('message_templates.*', 'message_categories.title','message_categories.id as catId','campuses.name',)
        ->join('message_categories', 'message_categories.id', '=', 'message_templates.messageCategoryId')
        ->join('campuses', 'campuses.id', '=', 'message_categories.campusId')
        ->whereIn('message_templates.campusId', $campusPermissions)
        ->where('message_templates.created_by', Auth::id())
        ->get();
        $categories  = MessageCategory::whereIn('campusId', $campusPermissions)->get();
        $gradeLevels  = GradeLevel::whereIn('campusId', $campusPermissions)->get();
        // return $gradeLevels;
        return view('message_templates_approval.index', [
            'templates'=>$templates, 
            'categories'=>$categories,
            'gradeLevels'=>$gradeLevels,
            'campuses'=>$campuses,
        ]);
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
    public function show(MessageTemplateApproval $messageTemplateApproval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MessageTemplateApproval $messageTemplateApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MessageTemplateApproval $messageTemplateApproval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MessageTemplateApproval $messageTemplateApproval)
    {
        //
    }
}
