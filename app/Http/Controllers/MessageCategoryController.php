<?php

namespace App\Http\Controllers;

use App\Models\MessageCategory;
use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class MessageCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'message-categories'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();


        $categories = MessageCategory::select('message_categories.*', 'campuses.name','campuses.id as campId')
        ->join('campuses', 'campuses.id', '=', 'message_categories.campusId')
        ->whereIn('campusId', $campusPermissions)
        ->where('created_by', Auth::id())
        ->get();
        return view('message_categories.index', [
            'categories'=>$categories,
            'campuses'=>$campuses,
        ]);
        // $search = $request->input('search');
        
        // $categories = MessageCategory::query()
        //     ->when($search, function ($query, $search) {
        //         return $query->where('title', 'like', '%' . $search . '%')
        //                     ->orWhere('status', $search);
        //     })
        //     ->paginate(5); // Adjust the number 10 to your desired items per page
        
        // return view('message_categories.index', compact('categories', 'search'));
    }

    public function create()
    {
        return view('message_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('message_categories')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'description' => 'nullable|string',
            'campusId' => 'required',
        ]);


        $campusIdCollection = $request->get('campusId');
        // return $campusIdCollection;
        $saveCounter=0;
        for($i=0;$i<sizeof($campusIdCollection);$i++){
            $campusId= $campusIdCollection[$i];
            $checkUniqueCount = MessageCategory::where('title',  $request->get('title'))
            ->where('campusId',  $campusId)
            ->count();
            if($checkUniqueCount==0){
                $category = new MessageCategory([
                    'title' => $request->get('title'),
                    'description' => $request->get('description'),
                    'campusId' => $campusId,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
                if ($category->save()) {
                    $saveCounter++;
                }
            }
        }
        if ($saveCounter!=0) {
            return redirect()->route('message-categories.index')->with('success', 'Message category [CREATED] successfully!');
        } else {
            return redirect()->route('message-categories.index')->with('error', 'Failed to [CREATE] message category!');
        }
        // $categoriesCount = MessageCategory::where('title',  $request->get('title'))->withTrashed()->count();
        // if($categoriesCount==1){
        //     $categories = MessageCategory::where('title',  $request->get('title'))->withTrashed()->first();
        //     $id= $categories->id;
        //     $category = MessageCategory::withTrashed()->findOrFail($id);
        //     $category->restore();
        //     return redirect()->route('message-categories.index')->with('info', 'Message category [RESTORED] successfully!');
        // }        
    }

    public function show(MessageCategory $messageCategory)
    {
        return view('message_categories.show', compact('messageCategory'));
    }

    public function edit(MessageCategory $messageCategory)
    {
        return view('message_categories.edit', compact('messageCategory'));
    }

    public function update(Request $request, MessageCategory $messageCategory)
    {
        $request->validate([
            'title' =>  'required',
            'description' => 'nullable|string',
            'campusId' => 'required',
        ]);
        $campusId = $request->get('campusId');;
        $checkUniqueCount = MessageCategory::where('title',  $request->get('title'))
        ->where('campusId',  $campusId)
        ->where('id','!=',  $messageCategory->id)
        ->count();
        if($checkUniqueCount==0)
        {
            $messageCategory->title = $request->get('title');
            $messageCategory->description = $request->get('description'); // Handle description
            $messageCategory->campusId = $request->get('campusId');
            $messageCategory->updated_by = auth()->id();

            if ($messageCategory->save()) {
                return redirect()->route('message-categories.index')->with('success', 'Message category [UPDATED] successfully!');
            } else {
                return redirect()->route('message-categories.index')->with('error', 'Failed to [UPDATE] message category!');
            }
        }
        else 
        {
            return redirect()->route('message-categories.index')->with('error', 'Failed to [UPDATE] message category, [REPATED TITLE]!');
        }
    }

    public function destroy(MessageCategory $messageCategory)
    {
        $messageCategory->delete();
        return redirect()->route('message-categories.index')->with('success', 'Category [DELETED] successfully.');
    }
    public function restore($id)
    {
        $category = MessageCategory::withTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('message-categories.index')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id)
    {
        $category = MessageCategory::withTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('message-categories.index')->with('success', 'Category [DELETED] permanently.');
    }

}
