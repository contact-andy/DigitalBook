<?php

namespace App\Http\Controllers;

use App\Models\MessageTemplate;
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
        $templates = MessageTemplate::all();
        return view('message_templates.index', compact('templates'));
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
        $request->validate([
            'content' => [
                'required',
                Rule::unique('message_templates')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'messageCategoryId' => 'required',
            'status' => 'required|boolean',
        ]);

        $categoriesCount = MessageTemplate::where('content',  $request->get('content'))->withTrashed()->count();
        if($categoriesCount==1){
            $categories = MessageTemplate::where('content',  $request->get('content'))->withTrashed()->first();
            $id= $categories->id;
            $template = MessageTemplate::withTrashed()->findOrFail($id);
            $template->restore();
            return redirect()->route('message-templates.index')->with('info', 'Message template [RESTORED] successfully!');
        }

        $template = new MessageTemplate([
            'content' => $request->get('content'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MessageTemplate $messageTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MessageTemplate $messageTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MessageTemplate $messageTemplate)
    {
        //
    }
}
