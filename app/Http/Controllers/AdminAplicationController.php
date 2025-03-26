<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplication;

class AdminAplicationController extends Controller
{
    function showeAdminAplication(){
        $aplications = Aplication::all(); // Получаем завки пользоватлей
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
            ]);
        }

        $aplication->status = $request->input('status');
        $aplication->save();

        return back()->with('success_' . $id, 'Статус заявки успешно обновлен');
    }
}
