<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('surveys.index', compact('surveys'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $survey = new Survey();
        $survey->title = $request->input('title');
        $survey->description = $request->input('description');
        $survey->status = $request->input('status');
        $survey->created_by = Auth::id();

        if ($survey->save()) {
            return redirect()->route('surveys.index')->with('success', 'Survey [CREATED] successfully!');
        } else {
            return redirect()->route('surveys.index')->with('error', 'Failed to [CREATE] Survey!');
        }

        //  $request->validate([
        //     'title' => 'required|string|max:255',
        //     'options' => 'required|array|min:2',
        //     'options.*' => 'required|string|max:255',
        // ]);

        // $survey = new Survey();
        // $survey->title = $request->input('title');
        // $survey->description = $request->input('description');
        // $survey->status = $request->input('status');
        // $survey->options = json_encode($request->input('options'));
        // $survey->created_by = Auth::id();

        // if ($survey->save()) {
        //     return redirect()->route('surveys.index')->with('success', 'Survey [CREATED] successfully!');
        // } else {
        //     return redirect()->route('surveys.index')->with('error', 'Failed to [CREATE] Survey!');
        // }
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
        ]);

        $survey = Survey::findOrFail($id);
        $survey->title = $request->input('title');
        $survey->description = $request->input('description');
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
