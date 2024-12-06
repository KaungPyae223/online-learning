<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return response()->json(
            [
                'data' => $category,
                'status' => 200
            ],
            200
        );
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
    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->category = $request->category;
        $category->save();

        return response()->json(
            [
                'message' => "Category added successfully",
                'data' => $category,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->category = $request->category;
        $category->update();

        return response()->json(
            [
                'message' => "Category updated successfully",
                'data' => $category,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(
            [
                'message' => "Category deleted successfully",
                'status' => 200
            ],
            200
        );
    }


}
