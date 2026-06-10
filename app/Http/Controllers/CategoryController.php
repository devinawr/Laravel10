<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        //method 1
        return view('categories.index', compact('categories'));
    }
     public function saveDataUpdate(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id);
        $data->category_name = $request->name;
        $data->save();
        return response()->json(array('status' => 'oke', 'msg' => 'type data is up-to-date !'), 200);
    }
    public function deleteData(Request $request)
{
    try {
        $id = $request->id;

        $data = Category::findOrFail($id);
        $data->delete();

        return response()->json([
            'status' => 'oke',
            'msg' => 'Category data is removed!'
        ], 200);
    } catch (\PDOException $ex) {
        return response()->json([
            'status' => 'error',
            'msg' => 'Make sure there is no related data before deleting it.'
        ], 500);
    }
}

  public function showInfo()
{
        $highestServiceCategory = Category::withCount('services')
            ->orderByDesc('services_count')
            ->first();

        return response()->json(array(
            'status' => 'oke',
            'msg' => '<div class="alert alert-success">The category with the most services is: <b>' . 
            $highestServiceCategory->category_name . '</b></div>'
        ),200);
 }
    public function showListServices(Request $request){
        $idcat = $request->input('idcat');
        $category = Category::find($idcat);
        
        if(!$category) {
            return response()->json([
                'status' => 'error',
                'title' => 'Not Found',
                'body' => 'Category not found'
            ], 404);
        }

        $services = $category->services;
        
        $serviceList = '<ul>';
        foreach($services as $service) {
            $serviceList .= '<li>' . $service->service_name . '</li>';
        }
        $serviceList .= '</ul>';

        return response()->json([
            'status' => 'ok',
            'title' => $category->name . ' Services',
            'body' => $serviceList
        ], 200);
    }
    public function getEditForm(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id);
        return response()->json(array(
            'status' => 'oke',
            'msg' => view('categories.getEditForm', compact('data'))->render()
            ),200);
    }
    public function getEditFormB(Request $request)
    {
        $id = $request->id;
        $data = Category::find($id);
        return response()->json(array(
          'status' => 'oke',
          'msg' => view('categories.getEditFormB', compact('data'))->render()
           ),200);
    }


    public function showExpensiveService()
    {   
        $categories = Category::with(['services' => function($query){
        $query->orderBy('price', 'desc');
        }])->get();

    return view('categories.expensiveservice', compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = new Category();
        $data->category_name = $request->get('name');
        $data->save();

        return redirect()->route('categories.index')->with('success', 'Successfully created data.');
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
    public function edit(Category $category)
    {
         return view('categories.edit',  compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
        'categoryName' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $category->category_name = $request->categoryName;
        if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('img/categories', 'public');
        $category->image = $imagePath;
        }
        $category->save();
        return redirect()->route('categories.index')->with('success', 'Successfully updated data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
       try {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Successfully deleted a category.');
        } 
        catch (\PDOException $ex) 
        {
            $msg = "Make sure there is no related data before deleting it. Please contact Administrator to know more about it.";
            return redirect()->route('categories.index')->with('status', $msg);
        }
    }
}
