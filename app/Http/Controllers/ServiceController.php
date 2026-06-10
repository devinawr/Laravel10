<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('services.index', compact('services'));
    }

    public function getEditFormB(Request $request)
    {
        $service = Service::findOrFail($request->id);
        $categories = Category::all();

        return response()->json([
            'status' => 'oke',
            'msg' => view('services.getEditFormB', compact('service', 'categories'))->render()
        ], 200);
    }

    public function saveDataUpdate(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:services,id',
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'availability' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service = Service::findOrFail($validated['id']);
        $service->update([
            'service_name' => $validated['service_name'],
            'description' => $validated['description'],
            'availability' => $validated['availability'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
        ]);

        return response()->json([
            'status' => 'oke',
            'msg' => 'Service updated successfully.'
        ], 200);
    }

    public function deleteData(Request $request)
    {
        try {
            $service = Service::findOrFail($request->id);
            $service->delete();

            return response()->json([
                'status' => 'oke',
                'msg' => 'Service removed successfully.'
            ], 200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unable to delete service.'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categoryId = $request->query('category_id');
        $categories = Category::all();
        return view('services.create', compact('categories', 'categoryId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'availability' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        Service::create($validated);
        
        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }
        $categories = Category::all();
        return view('services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'availability' => 'required|string|max:255',
            'price' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service->update($validated);
        
        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        if (!$service) {
            return redirect()->route('services.index')->with('error', 'Service not found.');
        }

        $service->delete();
        
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}
