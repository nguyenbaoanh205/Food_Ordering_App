<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $category;

    public function __construct()
    {
        $this->category = new Category();
    }
    public function index(Request $request)
    {
        // List categories, support search and pagination
        $query = $this->category->newQuery();

        $search = $request->query('q');
        if (!empty($search)) {
            $query->where('name', 'like', "%{$search}%");
        }

        $perPage = (int) $request->query('per_page', 10);
        $categories = $query->paginate($perPage);

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $this->category->create($request->all());
        return response()->json(["data" => $category], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->category->find($id);
        return response()->json(["data" => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = $this->category->find($id);
        $category->update($request->all());
        return response()->json(["data" => $category], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->category->find($id);
        $category->delete();
        return response()->json(["data" => $category], 200);
    }
}
