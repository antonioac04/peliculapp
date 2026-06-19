<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;

class DirectorController extends Controller
{
    public function index()
    {
        return response()->json(Director::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
        ]);

        $director = Director::create($validated);

        return response()->json($director, 201);
    }

    public function show(Director $director)
    {
        return response()->json($director->load('films'));
    }

    public function update(Request $request, Director $director)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'birthdate' => ['required', 'date'],
        ]);

        $director->update($validated);

        return response()->json($director);
    }

    public function destroy(Director $director)
    {
        $director->delete();

        return response()->json(null, 204);
    }
}
