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

class ResponseTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
               // Fetch Campus Permission
        $applicationListURL = 'response-templates'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
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
        return view('response_templates.index', [
            'templates'=>$templates,
            'messageTemplates'=>$messageTemplates,
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
        // dd($request->all()); // This will dump all request data

        $request->validate([
            'content' => 'required|string',
            'messageTemplateId' => 'required',
            'campusId' => 'required',
        ]);

        // return $request->get('messageTemplateId');

        $campusId = $request->get('campusId');;
        $checkUniqueCount = ResponseTemplate::where('content',  $request->get('content'))
        ->where('campusId',  $campusId)
        ->count();
        if($checkUniqueCount==0)
        {
            $messageTemplateIdCollection = $request->get('messageTemplateId');
            // return $messageTemplateIdCollection;
            $saveCounter=0;
            for($i=0;$i<sizeof($messageTemplateIdCollection);$i++)
            {
                $messageTemplateId= $messageTemplateIdCollection[$i];
                $checkUniqueCount = ResponseTemplate::where('content',  $request->get('content'))
                ->where('messageTemplateId',  $messageTemplateId)
                ->where('campusId',  $campusId)
                ->count();
                if($checkUniqueCount==0)
                {
                    $template = new ResponseTemplate([
                        'content' => $request->get('content'),
                        'messageTemplateId' => $messageTemplateId,
                        'campusId' => $request->get('campusId'),
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]);
                    if ($template->save()) {
                        $saveCounter++;
                    }
                }
            }
            if ($saveCounter!=0) {
                return redirect()->route('response-templates.index')->with('success', 'Response template['.$saveCounter.'] [CREATED] successfully!');
            }
            else{
                return redirect()->route('response-templates.index')->with('error', 'Unique response template required. Failed to [CREATE] response template!');
            }
        }
        else
        {
            return redirect()->route('response-templates.index')->with('error', 'Failed to [CREATE] response template, [REPATED CONTENT]!');
        }

        // $templatesCount = ResponseTemplate::where('content',  $request->get('content'))
        // ->where('messageTemplateId',  $request->get('messageTemplateId'))
        // ->withTrashed()->count();
        // if($templatesCount==1){
        //     $templates = ResponseTemplate::where('content',  $request->get('content'))
        //     ->where('messageTemplateId',  $request->get('messageTemplateId'))
        //     ->withTrashed()->first();
        //     $id= $templates->id;
        //     $template = ResponseTemplate::withTrashed()->findOrFail($id);
        //     $template->restore();
        //     return redirect()->route('response-templates.index')->with('info', 'Response template [RESTORED] successfully!');
        // }

        // return $request->get('messageTemplateId');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ResponseTemplate $responseTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResponseTemplate $responseTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, ResponseTemplate $responseTemplate)
    {
        $request->validate([
            'content' => 'required',
            'messageTemplateId' => 'required|string',
            'campusId' => 'required',
        ]);
        
        try
        {
            $campusId = $request->get('campusId');;
            $checkUniqueCount = ResponseTemplate::where('content',  $request->get('content'))
            ->where('campusId',  $campusId)
            ->where('id','!=',  $responseTemplate->id)
            ->count();
            if($checkUniqueCount==0)
            {
                $checkUniqueCount = ResponseTemplate::where('content',  $request->get('content'))
                ->where('messageTemplateId',  $request->get('messageTemplateId'))
                ->where('id','!=',  $responseTemplate->id)
                ->where('campusId',  $campusId)
                ->count();
                if($checkUniqueCount==0){
                
                    $k=ResponseTemplate::where('id', $responseTemplate->id)
                    ->update([
                        'content'=>$request->get('content'),
                        'messageTemplateId'=>$request->get('messageTemplateId'),
                        'campusId'=>$request->get('campusId'),
                        'updated_by'=>auth()->id(),
                    ]);

                    if ($k==1) {
                        return redirect()->route('response-templates.index')->with('success', 'Response message template [UPDATED] successfully!');
                    } else {
                        return redirect()->route('response-templates.index')->with('error', 'Failed to [UPDATE] response message template!');
                    }
                } 
                else 
                {
                    return redirect()->route('response-templates.index')->with('error', 'Unique content required. Failed to [UPDATE] response message template!');
                }
            }
            else{
                return redirect()->route('response-templates.index')->with('error', 'Failed to [CREATE] message template, [REPATED CONTENT]!');
            }
             
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect()->route('response-templates.index')->with('error', 'DB ERROR, Failed to [UPDATE] response message template!');
        }

        
    }

    public function destroy(ResponseTemplate $responseTemplate)
    {
        $responseTemplate->delete();
        return redirect()->route('response-templates.index')->with('success', 'Response messgae template [DELETED] successfully.');
    }
}
