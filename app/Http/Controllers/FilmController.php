<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    public function index()
    {
        return response()->json(Film::with('director')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'sinopsis' => ['required', 'string'],
            'duration' => ['required', 'integer'],
            'gendre' => ['required', 'string', 'max:255'],
            'director_id' => ['required', 'exists:directors,id'],
        ]);

        $film = Film::create($validated);

        return response()->json($film, 201);
    }

    public function show(Film $film)
    {
        return response()->json($film->load('director'));
    }

    public function update(Request $request, Film $film)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'release_date' => ['required', 'date'],
            'sinopsis' => ['required', 'string'],
            'duration' => ['required', 'integer'],
            'gendre' => ['required', 'string', 'max:255'],
            'director_id' => ['required', 'exists:directors,id'],
        ]);

        $film->update($validated);

        return response()->json($film);
    }

    public function destroy(Film $film)
    {
        $film->delete();

        return response()->json(null, 204);
    }
}