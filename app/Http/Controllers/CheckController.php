<?php

namespace App\Http\Controllers;

use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $checks = Check::all()->where('author', Auth::id());
        $checks->isEmpty() ? $checks = null : null; //я не нашел варианта лучше ибо коллекция наверху ВСЕГДА чем то заполнена

        return view('moneybox', [
            'checks' => $checks,
            'selected' => $request->selectedCheck //смотри мидлвейр UserCheckAccess, selectedCheck передается оттуда 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate(
            [
                'cardName' => ['required', 'max:16'],
            ],
            [
                'cardName.required' => 'Поле названия карточки обязательно!!!',
                'cardName.max' => 'Поле название карточки не должно привышать 16 символов!!!',
            ]
        );
        Check::create([
            'name' => $validatedData['cardName'],
            'author' => Auth::id(),
        ]);
        return back()->withSuccess('IT WORKS!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $request->selectedCheck->delete();
        return redirect()->route('moneybox');
    }
}