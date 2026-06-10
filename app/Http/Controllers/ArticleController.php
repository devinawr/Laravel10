<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = DB::table('articles')->get();
        return view('articles.index', compact('articles'));
    }

    public function getEditFormB(Request $request)
    {
        $article = Article::findOrFail($request->id);
        $doctors = Doctor::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('articles.getEditFormB', compact('article', 'doctors'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:articles,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'doctor_id' => 'nullable|exists:doctors,id',
        ]);

        $article = Article::findOrFail($validated['id']);
        $article->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'doctor_id' => $validated['doctor_id'],
        ]);

        return response()->json([
            'status' => 'oke',
            'msg' => 'Article updated successfully.'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        try {
            $article = Article::findOrFail($request->id);
            $article->delete();

            return response()->json([
                'status' => 'oke',
                'msg' => 'Article removed successfully.'
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unable to delete article.'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = Doctor::all();
        return view('articles.create', compact('doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'doctor_id' => 'nullable|exists:doctors,id',
        ]);

        Article::create($validated);

        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
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
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }
}
