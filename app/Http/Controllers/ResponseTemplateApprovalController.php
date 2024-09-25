<?php

namespace App\Http\Controllers;

use App\Models\ResponseTemplate;
use App\Models\MessageTemplate;
use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class ResponseTemplateApprovalController extends Controller
{
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'response-templates-approval'; $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();


        $templates = ResponseTemplate::select('response_templates.*', 'message_templates.id as tempId','message_templates.content as tempContent','campuses.name')
        ->join('message_templates', 'message_templates.id', '=', 'response_templates.messageTemplateId')
        ->join('campuses', 'campuses.id', '=', 'response_templates.campusId')
        ->whereIn('response_templates.campusId', $campusPermissions)
        ->where('response_templates.created_by', Auth::id())
        ->get();
        $messageTemplates  = MessageTemplate::whereIn('campusId', $campusPermissions)->get();
        return view('response_templates_approval.index', [
            'templates'=>$templates, 
            'messageTemplates'=>$messageTemplates,
            'campuses'=>$campuses,
        ]);
    }

    public function instantApprove(Request $request)
    {
        $id = $request->id;
        $contentOkValue = $request->contentOkValue;
        $grammarOkValue = $request->grammarOkValue;
        $spellingOkValue = $request->spellingOkValue;
        $messageTemplateCount = ResponseTemplate::where('id',$id)->count();
        if($messageTemplateCount)
        {
            $messageTemplate = ResponseTemplate::where('id',$id)->first();
            $messageTemplate->content_ok = $contentOkValue;
            $messageTemplate->grammar_ok = $grammarOkValue;
            $messageTemplate->spelling_ok = $spellingOkValue;
            $messageTemplate->approved_by  = Auth::id();
            $messageTemplate->save();
            
            return response()->json(['success' => true, 'message' => "Response Template status updated."]);
        }

        return response()->json(['success' => false, 'message' => 'Message template not found.'], 404);
    }

    public function approve(Request $request, ResponseTemplate $responseTemplate)
    {
        $id= $request->get('id');
        // return $request->get('gradeLevels');
        
        $campusId = $request->get('campusId');;
         $checkUniqueCount = ResponseTemplate::where('content',  $request->get('content'))
        ->where('campusId',  $campusId)
        ->where('id','!=',  $id)
        ->count();
        if($checkUniqueCount==0)
        {
            $responseTemplate = ResponseTemplate::where('id','=',  $id)->first();
            $responseTemplate->content_ok = $request->get('content_ok');
            $responseTemplate->grammar_ok = $request->get('grammar_ok');
            $responseTemplate->spelling_ok = $request->get('spelling_ok');
            $responseTemplate->comment = $request->get('comment');
            $responseTemplate->updated_by = auth()->id();
            $responseTemplate->approved_by = auth()->id();

            // echo $request->get('comment');
            if ($responseTemplate->save()) {
                return redirect()->route('response-templates-approval.index')->with('success', 'Message template status [UPDATED] successfully!');
            } else {
                return redirect()->route('response-templates-approval.index')->with('error', 'Failed to [UPDATE] message template status!');
            }
        }
        else 
        {
            return redirect()->route('response-templates-approval.index')->with('error', 'Failed to [UPDATE] message response template status, [REPATED TITLE]!');
        }
    }
}
