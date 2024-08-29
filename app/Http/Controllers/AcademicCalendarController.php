<?php

namespace App\Http\Controllers;

use App\Models\AcademicCalendar;
use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    public function index()
    {
        $calendars = AcademicCalendar::all();
        $recentEvents = AcademicCalendar::whereDate('start_date','>=', date('Y-m-d'))
        ->orderBy('start_date', 'ASC')->get();
        return view('academic_calendars.index', [
            'calendars'=>$calendars,
            'recentEvents'=>$recentEvents,
        ]);
    }

    public function create()
    {
        return view('academic_calendars.create');
    }

    public function store(Request $request)
    {
        $academicYear = 2017;
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $event = new AcademicCalendar([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'color' => $request->get('color'),
            'status' => $request->get('status'),
            'academicYear' => $academicYear,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        if ($event->save()) {
            return redirect()->route('academic-calendars.index')->with('success', 'Calendar event [CREATED] successfully!');
        } else {
            return redirect()->route('academic-calendars.index')->with('error', 'Failed to [CREATE] message category!');
        }
    }

    public function show(AcademicCalendar $academicCalendar)
    {
        return view('academic_calendars.show', compact('academicCalendar'));
    }

    public function edit(AcademicCalendar $academicCalendar)
    {
        return view('academic_calendars.edit', compact('academicCalendar'));
    }

    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $academicCalendar->update($request->all());
        return redirect()->route('academic_calendars.index')->with('success', 'Academic Calendar updated successfully.');
    }

    public function destroy(AcademicCalendar $academicCalendar)
    {
        $academicCalendar->delete();
        return redirect()->route('academic_calendars.index')->with('success', 'Academic Calendar deleted successfully.');
    }
}
