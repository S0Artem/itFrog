<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Branch, LessonTime, Group, Modul, GroupTeacher};

class SheduleController extends Controller
{
    public function showe()
    {
        $branches = Branch::all();
        $selectedBranch = request('branch_id') ?? $branches->first()->id;
        return view('admin.shedule.sheduleAdmin', [
            'branches' => $branches,
            'selectedBranch' => $selectedBranch,
            'times' => LessonTime::orderBy('lesson_start')->get(),
            'moduls' => Modul::all(),
            'groups' => Group::with(['modul', 'time'])
                ->where('branch_id', $selectedBranch)
                ->get()
                ->groupBy(['day', 'time_id'])
        ]);
    }


    public function showeTeacher()
    {
        $idTeacher = Auth::user()->id;
        $groopTeacher = GroupTeacher::where('employee_id', $idTeacher)->pluck('group_id');
        $grops = Group::with(['modul', 'time'])
            ->whereIn('id', $groopTeacher)
            ->get()
            ->groupBy(['day', 'time_id']);

        return view('admin.shedule.sheduleTeacher', [
            'times' => LessonTime::orderBy('lesson_start')->get(),
            'groups' => $grops,
        ]);
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'modul_id' => 'required|exists:moduls,id',
            'time_id' => 'required|exists:lesson_times,id',
            'day' => 'required|integer|between:1,7'
        ]);

        $group = Group::create([
            'branch_id' => $validated['branch_id'],
            'modul_id' => $validated['modul_id'],
            'time_id' => $validated['time_id'],
            'day' => $validated['day']
        ]);

        return back()->with('success', 'Группа добавлена!');
    }
}