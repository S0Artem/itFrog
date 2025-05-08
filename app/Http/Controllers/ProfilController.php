<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use App\Models\Branch;
use App\Models\ModulStudent;

class ProfilController extends Controller
{
    public function showe()
    {
        $userId = Auth::id();

        $userInfo = User::find($userId, ['email', 'name', 'number']);
        $userStudents = Student::with([
            'branch',
            'groups.time',
            'groups.modul',
            'groups.teachers.user',
        ])->where('user_id', $userId)
        ->get();

        return view('profil.profil', compact('userInfo', 'userStudents'));
    }
}
