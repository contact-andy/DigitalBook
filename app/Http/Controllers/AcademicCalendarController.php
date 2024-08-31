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
        // return $request->get('end_date');
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
            return redirect()->route('academic-calendars.index')->with('success', 'Event [CREATED]!');
        } else {
            return redirect()->route('academic-calendars.index')->with('error', 'Failed to [CREATE]');
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
            'editTitle' => 'required|string|max:255',
            'editStart_date' => 'required|date',
            'editEnd_date' => 'required|date|after_or_equal:start_date',
        ]);

        $id= $request->get('editId');
        $title= $request->get('editTitle');
        $description = $request->get('editDescription');
        $editStart_date = $request->get('editStart_date');
        $editEnd_date = $request->get('editEnd_date');
        $editColor = $request->get('editColor');
        $editStatus = $request->get('editStatus');
        $academicYear = 2017;

        $res = AcademicCalendar::where('id',$id)->update([
            'title' => $request->get('editTitle'),
            'description' => $request->get('editDescription'),
            'start_date' => $request->get('editStart_date'),
            'end_date' => $request->get('editEnd_date'),
            'color' => $request->get('editColor'),
            'status' => $request->get('editStatus'),
            'academicYear' => $academicYear,
            'updated_by' => auth()->id(),
        ]);
        if ($res==1) {
            return redirect()->route('academic-calendars.index')->with('success', 'Event [UPDATED]!');
        } else {
            return redirect()->route('academic-calendars.index')->with('error', 'Failed to [UPDATE]!');
        }
    }

    public function destroy(Request $request, AcademicCalendar $academicCalendar)
    {
        $id = $request->get('deleteId');
        $res=AcademicCalendar::where('id',$id)->delete();
        if ($res==1) {
            return redirect()->route('academic-calendars.index')->with('success', 'Event [DELETED]!');
        } else {
            return redirect()->route('academic-calendars.index')->with('error', 'Failed to [DELETE]!');
        }
    }
}
