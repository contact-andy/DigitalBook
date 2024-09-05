<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::all();
        return view('event_categories.index', compact('categories'));
        // $search = $request->input('search');
        
        // $categories = EventCategory::query()
        //     ->when($search, function ($query, $search) {
        //         return $query->where('title', 'like', '%' . $search . '%')
        //                     ->orWhere('status', $search);
        //     })
        //     ->paginate(5); // Adjust the number 10 to your desired items per page
        
        // return view('event_categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('event_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('event_categories')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'color' => 'required',
        ]);

        $categoriesCount = EventCategory::where('title',  $request->get('title'))->withTrashed()->count();
        if($categoriesCount==1){
            $categories = EventCategory::where('title',  $request->get('title'))->withTrashed()->first();
            $id= $categories->id;
            $category = EventCategory::withTrashed()->findOrFail($id);
            $category->restore();
            return redirect()->route('event-categories.index')->with('info', 'Event category [RESTORED] successfully!');
        }

        $category = new EventCategory([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'color' => $request->get('color'),
            'status' => $request->get('status'),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        if ($category->save()) {
            return redirect()->route('event-categories.index')->with('success', 'Event category [CREATED] successfully!');
        } else {
            return redirect()->route('event-categories.index')->with('error', 'Failed to [CREATE] event category!');
        }
    }

    public function show(EventCategory $eventCategory)
    {
        return view('event_categories.show', compact('eventCategory'));
    }

    public function edit(EventCategory $eventCategory)
    {
        return view('event_categories.edit', compact('eventCategory'));
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $request->validate([ 
            'title' => [
                'required',
                Rule::unique('event_categories')->whereNull('deleted_at')->ignore($eventCategory->id),
            ],
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'color' => 'required',
        ]);

        $eventCategory->title = $request->get('title');
        $eventCategory->description = $request->get('description'); // Handle description
        $eventCategory->color = $request->get('color');
        $eventCategory->status = $request->get('status');
        $eventCategory->updated_by = auth()->id();

        if ($eventCategory->save()) {
            return redirect()->route('event-categories.index')->with('success', 'Event category [UPDATED] successfully!');
        } else {
            return redirect()->route('event-categories.index')->with('error', 'Failed to [UPDATE] event category!');
        }
    }

    public function destroy(EventCategory $eventCategory)
    {
        $eventCategory->delete();
        return redirect()->route('event-categories.index')->with('success', 'Category [DELETED] successfully.');
    }
    public function restore($id)
    {
        $category = EventCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('event-categories.index')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = EventCategory::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('event-categories.index')->with('success', 'Category [DELETED] permanently.');
    }
}
