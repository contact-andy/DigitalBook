<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventCategoryController extends Controller
{
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'event-categories'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();

        // $categories = EventCategory::where('created_by', Auth::id())
        // ->get();
        // return view('event_categories.index', compact('categories'));

        $categories = EventCategory::select('event_categories.*', 'campuses.name','campuses.id as campId')
        ->join('campuses', 'campuses.id', '=', 'event_categories.campusId')
        ->whereIn('campusId', $campusPermissions)
        ->where('created_by', Auth::id())
        ->get();
        return view('event_categories.index', [
            'categories'=>$categories,
            'campuses'=>$campuses,
        ]);


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
            'title' => 'required',
            'description' => 'nullable|string',
            'color' => 'required',
            'campusId' => 'required',
        ]);

        $campusIdCollection = $request->get('campusId');
        // return $campusIdCollection;
        $saveCounter=0;
        for($i=0;$i<sizeof($campusIdCollection);$i++){
            $campusId= $campusIdCollection[$i];
            $checkUniqueCount = EventCategory::where('title',  $request->get('title'))
            ->where('campusId',  $campusId)
            ->count();
            if($checkUniqueCount==0){
                $event = new EventCategory([
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'color' => $request->get('color'),
                    'campusId' => $campusId,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
                if ($event->save()) {
                    $saveCounter++;
                }
            }
        }
        if ($saveCounter!=0) {
            return redirect()->route('event-categories.index')->with('success', 'Event category [CREATED] successfully!');
        } else {
            return redirect()->route('event-categories.index')->with('error', 'Failed to [CREATE] event category!');
        }

        // $categoriesCount = EventCategory::where('title',  $request->get('title'))->withTrashed()->count();
        // if($categoriesCount==1){
        //     $categories = EventCategory::where('title',  $request->get('title'))->withTrashed()->first();
        //     $id= $categories->id;
        //     $category = EventCategory::withTrashed()->findOrFail($id);
        //     $category->restore();
        //     return redirect()->route('event-categories.index')->with('info', 'Event category [RESTORED] successfully!');
        // }

        // $category = new EventCategory([
        //     'title' => $request->get('title'),
        //     'description' => $request->get('description'),
        //     'color' => $request->get('color'),
        //     'status' => $request->get('status'),
        //     'created_by' => auth()->id(),
        //     'updated_by' => auth()->id(),
        // ]);

        // if ($category->save()) {
        //     return redirect()->route('event-categories.index')->with('success', 'Event category [CREATED] successfully!');
        // } else {
        //     return redirect()->route('event-categories.index')->with('error', 'Failed to [CREATE] event category!');
        // }
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
            'title' => 'required',
            'description' => 'nullable|string',
            'campusId' => 'required',
            'color' => 'required',
        ]);


        $campusId = $request->get('campusId');;
        $checkUniqueCount = EventCategory::where('title',  $request->get('title'))
        ->where('campusId',  $campusId)
        ->where('id','!=',  $eventCategory->id)
        ->count();
        if($checkUniqueCount==0)
        {
            $eventCategory->title = $request->get('title');
            $eventCategory->description = $request->get('description'); // Handle description
            $eventCategory->campusId = $request->get('campusId');
            $eventCategory->color = $request->get('color');
            $eventCategory->updated_by = auth()->id();

            if ($eventCategory->save()) {
                return redirect()->route('event-categories.index')->with('success', 'Event category [UPDATED] successfully!');
            } else {
                return redirect()->route('event-categories.index')->with('error', 'Failed to [UPDATE] event category!');
            }
        }
        else 
        {
            return redirect()->route('event-categories.index')->with('error', 'Failed to [UPDATE] event category!');
        }

        // $eventCategory->title = $request->get('title');
        // $eventCategory->description = $request->get('description'); // Handle description
        // $eventCategory->color = $request->get('color');
        // $eventCategory->updated_by = auth()->id();

        // if ($eventCategory->save()) {
        //     return redirect()->route('event-categories.index')->with('success', 'Event category [UPDATED] successfully!');
        // } else {
        //     return redirect()->route('event-categories.index')->with('error', 'Failed to [UPDATE] event category!');
        // }
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

    public function eventApproval()
    {
        // Fetch Campus Permission
        $applicationListURL = 'event-approval'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();

        $categories = EventCategory::select('event_categories.*', 'campuses.name','campuses.id as campId')
        ->join('campuses', 'campuses.id', '=', 'event_categories.campusId')
        ->whereIn('campusId', $campusPermissions)
        ->where('created_by', Auth::id())
        ->get();
        return view('category_approval.index', [
            'categories'=>$categories,
            'campuses'=>$campuses,
        ]);
    }
    public function approve(Request $request, EventCategory $eventCategory)
    {
        $id= $request->get('id');
        $request->validate([
            'title' =>  'required',
            'description' => 'nullable|string',
            'campusId' => 'required',
        ]);
        $campusId = $request->get('campusId');;
        $checkUniqueCount = EventCategory::where('title',  $request->get('title'))
        ->where('campusId',  $campusId)
        ->where('id','!=',  $id)
        ->count();
        if($checkUniqueCount==0)
        {
            $eventCategory = EventCategory::where('id','=',  $id)->first();
            $eventCategory->title = $request->get('title');
            $eventCategory->description = $request->get('description'); // Handle description
            $eventCategory->campusId = $request->get('campusId');
            $eventCategory->color = $request->get('color');
            $eventCategory->status = $request->get('status');
            $eventCategory->updated_by = auth()->id();

            if ($eventCategory->save()) {
                return redirect()->route('event-approval.index')->with('success', 'Message category status [UPDATED] successfully!');
            } else {
                return redirect()->route('event-approval.index')->with('error', 'Failed to [UPDATE] message category status!');
            }
        }
        else 
        {
            return redirect()->route('event-approval.index')->with('error', 'Failed to [UPDATE] message category status, [REPATED TITLE]!');
        }
    }
    public function instantApprove(Request $request)
    {
        $eventCategory = EventCategory::find($request->id);
        $status = $request->status;
        if ($eventCategory) {
            $eventCategory->status = $status;
            $eventCategory->updated_by = Auth::id();
            $eventCategory->save();

            return response()->json(['success' => true, 'message' => 'Message category approved successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Message category not found.'], 404);
    }
}
