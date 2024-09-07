<?php

namespace App\Http\Controllers;

use App\Models\Survey;

use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        // Fetch Campus Permission
        $applicationListURL = 'surveys'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();

        $surveys = Survey::select('surveys.*', 'campuses.name','campuses.id as campId')
        ->join('campuses', 'campuses.id', '=', 'surveys.campusId')
        ->whereIn('campusId', $campusPermissions)
        ->where('created_by', Auth::id())
        ->get();

        return view('surveys.index', [
            'surveys'=>$surveys,
            'campuses'=>$campuses,
        ]);
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'campusId'=>'required'
        ]);

        $campusIdCollection = $request->get('campusId');
        // return $campusId;
        $saveCounter=0;
        for($i=0;$i<sizeof($campusIdCollection);$i++)
        {
            $campusId= $campusIdCollection[$i];
            $checkUniqueCount = Survey::where('title',  $request->get('title'))
            ->where('campusId',  $campusId)
            ->count();
            if($checkUniqueCount==0)
            {
                $survey = new Survey([
                    'title' => $request->get('title'),
                    'campusId' => $campusId,
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]);
                if ($survey->save()) {
                    $saveCounter++;
                }
            }
        }
        if ($saveCounter!=0) {
            return redirect()->route('surveys.index')->with('success', 'Survey [CREATED] successfully!');
        } else {
            return redirect()->route('surveys.index')->with('error', 'Failed to [CREATE] Survey!');
        }
    }

    public function show($id)
    {
        $survey = Survey::findOrFail($id);
        return view('surveys.show', compact('survey'));
    }

    public function edit($id)
    {
        $survey = Survey::findOrFail($id);
        return view('surveys.edit', compact('survey'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'campusId' => 'required',
        ]);

        $survey = Survey::findOrFail($id);
        $survey->title = $request->input('title');
        $survey->description = $request->input('description');
        $survey->campusId = $request->input('campusId');
        $survey->updated_by = Auth::id();
        $survey->save();

        return redirect()->route('surveys.index')->with('success', 'Survey updated successfully.');
    }

    public function destroy($id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();

        return redirect()->route('surveys.index')->with('success', 'Survey deleted successfully.');
    }
}
