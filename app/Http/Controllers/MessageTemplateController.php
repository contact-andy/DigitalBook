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

class MessageTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'message-templates'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
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
        return view('message_templates.index', [
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
        return view('message_templates.create');
    }

    public function store(Request $request)
    {
        // dd($request->all()); // This will dump all request data

        $request->validate([
            'content' => 'required|string',
            'messageCategoryId' => 'required|string',
            'campusId' => 'required',
            'gradeLevels' => 'required|array',
        ]);

        $campusId = $request->get('campusId');;
        $checkUniqueCount = MessageTemplate::where('content',  $request->get('content'))
        ->where('campusId',  $campusId)
        ->count();
        if($checkUniqueCount==0)
        {
            $templatesCount = MessageTemplate::where('content',  $request->get('content'))
            ->where('campusId',  $campusId)->withTrashed()->count();
            if($templatesCount==1){
                $templates = MessageTemplate::where('content',  $request->get('content'))
                ->where('campusId',  $campusId)->withTrashed()->first();
                $id= $templates->id;
                $template = MessageTemplate::withTrashed()->findOrFail($id);
                $template->restore();
                return redirect()->route('message-templates.index')->with('info', 'Message template [RESTORED] successfully!');
            }
            $template = new MessageTemplate([
                'content' => $request->get('content'),
                'type' => $request->get('type'),
                'messageCategoryId' => $request->get('messageCategoryId'),
                'campusId' => $request->get('campusId'),
                'gradeLevels' => json_encode($request->gradeLevels),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // return $template;
            if ($template->save()) {
                return redirect()->route('message-templates.index')->with('success', 'Message template [CREATED] successfully!');
            } else {
                return redirect()->route('message-templates.index')->with('error', 'Failed to [CREATE] message template!');
            }
        }
        else 
        {
            return redirect()->route('message-templates.index')->with('error', 'Failed to [CREATE] message template, [REPATED CONTENT]!');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(MessageTemplate $messageTemplate)
    {
        return view('message_templates.show', compact('messageTemplate'));
    }

    public function edit(MessageTemplate $messageTemplate)
    {
        return view('message_templates.edit', compact('messageTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MessageTemplate $messageTemplate)
    {
        $request->validate([
            'content' => 'required',
            'messageCategoryId' => 'required|string',
            'campusId' => 'required|boolean',
        ]);
        
        try
        {
            $campusId = $request->get('campusId');;
            $checkUniqueCount = MessageTemplate::where('content',  $request->get('content'))
            ->where('campusId',  $campusId)
            ->where('id','!=',  $messageTemplate->id)
            ->count();
            if($checkUniqueCount==0)
            {
                $k=MessageTemplate::where('id', $messageTemplate->id)
                ->update([
                    'content'=>$request->get('content'),
                    'type'=>$request->get('type'),
                    'messageCategoryId'=>$request->get('messageCategoryId'),
                    'campusId'=>$request->get('campusId'),
                    'gradeLevels' => json_encode($request->gradeLevels),
                    'updated_by'=>auth()->id(),
                ]);

                if ($k==1) {
                    return redirect()->route('message-templates.index')->with('success', 'Message template [UPDATED] successfully!');
                } else {
                    return redirect()->route('message-templates.index')->with('error', 'Failed to [UPDATE] message template!');
                }
            }
            else 
            {
                return redirect()->route('message-templates.index')->with('error', 'Failed to [CREATE] message template, [REPATED CONTENT]!');
            }
            
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            return redirect()->route('message-templates.index')->with('error', 'DB ERROR, Failed to [UPDATE] message template!');
        }

        
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        $messageTemplate->delete();
        return redirect()->route('message-templates.index')->with('success', 'Template [DELETED] successfully.');
    }
}
