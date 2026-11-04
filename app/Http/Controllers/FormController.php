<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    public function showForm()
    {
        return view('form');
    }

    public function submitForm(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|min:2',
            'email'   => 'required|email',
            'message' => 'required',
        ], [
            'name.min' => 'Имя должно содержать минимум 2 символа.',
        ]);

        $data['created_at'] = now()->format('d.m.Y H:i');

        $fileName = uniqid() . '.json';

        Storage::put("records/{$fileName}", json_encode($data, JSON_UNESCAPED_UNICODE));

        return back()->with('success', 'Файл успешно сохранен!');
    }

    public function showRecords()
    {
        $records = [];
        $files = Storage::files('records'); 

        foreach ($files as $file) {
            $content = Storage::get($file);
            $records[] = json_decode($content, true); 
        }

        return view('records', compact('records'));
    }
}