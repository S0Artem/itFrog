<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplication;
use App\Models\Branch;
use Carbon\Carbon;

class AdminAplicationController extends Controller
{
    public function showeAdminAplication()
    {
        $aplications = Aplication::all()->map(function($aplication) {
            if ($aplication->student_birth_date) {
                $age = Carbon::parse($aplication->student_birth_date)->diff(now());
                $aplication->age_text = $age->y . ' года ' . $age->m . ' месяцев';
            } else {
                $aplication->age_text = 'нету инфы';
            }
            $aplication->branche = Branch::find($aplication->branche_id);
            return $aplication;
        });

        return view('admin.adminAplication.aplication', compact('aplications'));
    }

    public function aplicationChange(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Новая,В работе,Отказ,Обработана',
        ]);

        $aplication = Aplication::findOrFail($id);
        if ($aplication->status === 'Созданная') {
            return back()->withErrors([
                'aplication_' . $id => 'Невозможно изменить заявку, по которой был создан пользователь'
            ])->withFragment('aplication_' . $id);
        }

        $aplication->status = $request->input('status');
        $aplication->save();

        return back()->with('success_' . $id, 'Статус заявки успешно обновлен')
            ->withFragment('aplication_' . $id);
    }
}
