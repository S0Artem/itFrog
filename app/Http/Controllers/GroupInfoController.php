<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Branch;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupInfoController extends Controller
{
    public function show(Group $group)
    {
        try {
            $branches = Branch::all();
            $selectedBranch = request('branch_id') ?? $group->branch_id;
            
            $group->load([
                'modul',
                'students.user',
                'teacher.employee.user' => function($query) {
                    $query->select('id', 'name', 'number');
                }
            ]);
            
            $teacherName = 'Не назначен';
            $teacherPhone = 'Не указан';
            
            if ($group->teacher && $group->teacher->employee && $group->teacher->employee->user) {
                $teacherName = $group->teacher->employee->user->name;
                $teacherPhone = $group->teacher->employee->user->number ?? 'Не указан';
            }
            
            $students = $group->students->map(function($student) {
                return [
                    'name' => $student->user->name ?? 'Не указано',
                    'phone' => $student->user->number ?? 'Не указан',
                    'birthdate' => $student->birthdate
                ];
            });
            
            return view('admin.groupInfo.groupInfo', [
                'group' => $group,
                'branches' => $branches,
                'selectedBranch' => $selectedBranch,
                'teacherName' => $teacherName,
                'teacherPhone' => $teacherPhone,
                'students' => $students
            ]);
            
        } catch (ModelNotFoundException $e) {
            abort(404, 'Группа не найдена');
        }
    }
}