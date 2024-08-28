<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
use App\Models\MessageCategory;

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
        $templates = MessageTemplate::select('message_templates.*', 'message_categories.title','message_categories.id as catId')
        ->join('message_categories', 'message_categories.id', '=', 'message_templates.messageCategoryId')
        ->get();
        $categories  = MessageCategory::all();
        return view('message_templates.index', [
            'templates'=>$templates,
            'categories'=>$categories
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
            'status' => 'required|boolean',
        ]);

        $templatesCount = MessageTemplate::where('content',  $request->get('content'))->withTrashed()->count();
        if($templatesCount==1){
            $templates = MessageTemplate::where('content',  $request->get('content'))->withTrashed()->first();
            $id= $templates->id;
            $template = MessageTemplate::withTrashed()->findOrFail($id);
            $template->restore();
            return redirect()->route('message-templates.index')->with('info', 'Message template [RESTORED] successfully!');
        }

        // return $request->get('messageCategoryId');

        $template = new MessageTemplate([
            'content' => $request->get('content'),
            'type' => $request->get('type'),
            'messageCategoryId' => $request->get('messageCategoryId'),
            'status' => $request->get('status'),
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
            'content' => 'required|string',
            'messageCategoryId' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $messageTemplate->content = $request->get('content');
        $messageTemplate->type = $request->get('type'); 
        $messageTemplate->messageCategoryId = $request->get('messageCategoryId'); 
        $messageTemplate->status = $request->get('status');
        $messageTemplate->updated_by = auth()->id();

        if ($messageTemplate->save()) {
            return redirect()->route('message-templates.index')->with('success', 'Message template [UPDATED] successfully!');
        } else {
            return redirect()->route('message-templates.index')->with('error', 'Failed to [UPDATE] message template!');
        }
    }

    public function destroy(MessageTemplate $messageTemplate)
    {
        $messageTemplate->delete();
        return redirect()->route('message-templates.index')->with('success', 'Template [DELETED] successfully.');
    }
}
