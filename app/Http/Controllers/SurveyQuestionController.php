<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use App\Models\Survey;

class SurveyQuestionController extends Controller
{
    public function index()
    {
        // $surveyQuestions = SurveyQuestion::with('survey')->paginate(10); // Pagination added
        // return view('survey_questions.index', compact('surveyQuestions'));

        $surveyQuestions = SurveyQuestion::select('survey_questions.*', 'surveys.title','surveys.id as surveyId')
        ->join('surveys', 'surveys.id', '=', 'survey_questions.survey_id')
        ->get();
        $surveyCategory  = Survey::all();
        return view('survey_questions.index', [
            'surveyQuestions'=>$surveyQuestions,
            'surveyCategory'=>$surveyCategory
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
        ]);
        
        $is_required=false;
        if($request->is_required==1)
            $is_required=true;
        SurveyQuestion::create([
            'survey_id' => $request->survey_id,
            'question' => $request->question,
            'options' => json_encode($request->options),
            'type' => $request->type,
            'is_required' => $is_required,
            'status' => $request->get('status'),
            'created_by' => auth()->user()->id, // Set the creator's ID
        ]);

        return redirect()->route('survey-questions.index')->with('success', 'Survey Question created successfully.');
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
            'status' => $request->get('status'),
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