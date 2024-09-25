<?php

namespace App\Http\Controllers;

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
        $applicationListURL = 'message-templates-approval'; $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();
        $templates = MessageTemplate::select('message_templates.*', 'message_categories.title','message_categories.id as catId','campuses.name','campuses.id as campusId',)
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

    public function instantApprove(Request $request)
    {
        $id = $request->id;
        $contentOkValue = $request->contentOkValue;
        $grammarOkValue = $request->grammarOkValue;
        $spellingOkValue = $request->spellingOkValue;
        $messageTemplateCount = MessageTemplate::where('id',$id)->count();
        if($messageTemplateCount)
        {
            $messageTemplate = MessageTemplate::where('id',$id)->first();
            $messageTemplate->content_ok = $contentOkValue;
            $messageTemplate->grammar_ok = $grammarOkValue;
            $messageTemplate->spelling_ok = $spellingOkValue;
            $messageTemplate->approved_by  = Auth::id();
            $messageTemplate->save();
            
            return response()->json(['success' => true, 'message' => $messageTemplate]);
        }

        return response()->json(['success' => false, 'message' => 'Message template not found.'], 404);
    }

    public function approve(Request $request, MessageTemplate $messageTemplate)
    {
        $id= $request->get('id');
        // return $request->get('gradeLevels');
        $request->validate([
            'content' => 'required|string',
            'messageCategoryId' => 'required|string',
            'campusId' => 'required',
            // 'gradeLevels' => 'required',
        ]);
        $campusId = $request->get('campusId');;
         $checkUniqueCount = MessageTemplate::where('content',  $request->get('content'))
        ->where('campusId',  $campusId)
        ->where('id','!=',  $id)
        ->count();
        if($checkUniqueCount==0)
        {
            $messageTemplate = MessageTemplate::where('id','=',  $id)->first();
            $messageTemplate->content = $request->get('content');
            $messageTemplate->type = $request->get('type'); 
            $messageTemplate->messageCategoryId = $request->get('messageCategoryId');
            $messageTemplate->campusId = $request->get('campusId');
            // $messageTemplate->gradeLevels = $request->get('gradeLevels');
            $messageTemplate->content_ok = $request->get('content_ok');
            $messageTemplate->grammar_ok = $request->get('grammar_ok');
            $messageTemplate->spelling_ok = $request->get('spelling_ok');
            $messageTemplate->comment = $request->get('comment');
            $messageTemplate->updated_by = auth()->id();
            $messageTemplate->approved_by = auth()->id();

            // echo $request->get('comment');
            if ($messageTemplate->save()) {
                return redirect()->route('message-templates-approval.index')->with('success', 'Message template status [UPDATED] successfully!');
            } else {
                return redirect()->route('message-templates-approval.index')->with('error', 'Failed to [UPDATE] message template status!');
            }
        }
        else 
        {
            return redirect()->route('message-templates-approval.index')->with('error', 'Failed to [UPDATE] message template status, [REPATED TITLE]!');
        }
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
