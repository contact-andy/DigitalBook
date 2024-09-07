<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use App\Models\Survey;
use App\Models\Campuse;
use App\Models\DcbApplicationPermission;
use App\Models\DcbApplicationList;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SurveyQuestionController extends Controller
{
    public function index()
    {
        // $surveyQuestions = SurveyQuestion::with('survey')->paginate(10); // Pagination added
        // return view('survey_questions.index', compact('surveyQuestions'));
        // Fetch Campus Permission
        $applicationListURL = 'survey-questions'; 
        $applicationList = DcbApplicationList::where('url',$applicationListURL)->first(); 
        $applicationListId = $applicationList->id;
        $campusPermissions = DcbApplicationPermission::where('userId', Auth::id())
        ->where('appId', $applicationListId)->pluck('campusId')->toArray();
        $campuses =  Campuse::whereIn('id', $campusPermissions)->get();

        $surveyQuestions = SurveyQuestion::select('survey_questions.*', 'surveys.title','surveys.id as surveyId','campuses.name','campuses.id as campId')
        ->join('surveys', 'surveys.id', '=', 'survey_questions.survey_id')
        ->join('campuses', 'campuses.id', '=', 'survey_questions.campusId')
        ->whereIn('survey_questions.campusId', $campusPermissions)
        ->where('survey_questions.created_by', Auth::id())
        ->get();
        $surveyCategory  = Survey::whereIn('campusId', $campusPermissions)->get();
        return view('survey_questions.index', [
            'surveyQuestions'=>$surveyQuestions,
            'surveyCategory'=>$surveyCategory,
            'campuses'=>$campuses
        ]);
    }

    public function create()
    {
        $surveys = Survey::all();
        return view('survey_questions.create', compact('surveys'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'question' => 'required|max:255',
            'options' => 'required|array',
            'type' => 'required|string',
            'is_required' => 'boolean',
            'campusId'=>'required',
        ]);
        
        $is_required=false;
        if($request->is_required==1)
            $is_required=true;
        
        $surveyQuestion = new SurveyQuestion([
             'survey_id' => $request->survey_id,
            'question' => $request->question,
            'options' => json_encode($request->options),
            'type' => $request->type,
            'campusId' => $request->campusId,
            'is_required' => $is_required,
            'created_by' => auth()->user()->id, // Set the creator's ID
        ]);
        if ($surveyQuestion->save()) {
            return redirect()->route('survey-questions.index')->with('success', 'Survey Question created successfully.');
        } else {
            return redirect()->route('surveys.index')->with('error', 'Failed to [CREATE] Survey Question!');
        }
    }

    public function show(SurveyQuestion $surveyQuestion)
    {
        return view('survey_questions.show', compact('surveyQuestion'));
    }

    public function edit(SurveyQuestion $surveyQuestion)
    {
        $surveys = Survey::all();
        return view('survey_questions.edit', compact('surveyQuestion', 'surveys'));
    }

    public function update(Request $request, SurveyQuestion $surveyQuestion)
    {
        $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'question' => 'required|max:255',
            'options' => 'required|array',
            'type' => 'required|string',
            'is_required' => 'boolean',
            'campusId'=>'required',
        ]);
        $is_required=false;
        if($request->is_required==1)
            $is_required=true;

        $surveyQuestion->update([
            'survey_id' => $request->survey_id,
            'question' => $request->question,
            'options' => json_encode($request->options),
            'type' => $request->type,
            'is_required' => $is_required,
            'campusId' => $request->get('campusId'),
            'updated_by' => auth()->user()->id, // Set the updater's ID
        ]);

        return redirect()->route('survey-questions.index')->with('success', 'Survey Question updated successfully.');
    }


    public function destroy(SurveyQuestion $surveyQuestion)
    {
        $surveyQuestion->delete();

        return redirect()->route('survey-questions.index')->with('success', 'Survey Question deleted successfully.');
    }
}