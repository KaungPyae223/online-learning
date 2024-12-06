<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurriculumRequest;
use App\Http\Requests\UpdateCurriculumRequest;
use App\Models\Curriculum;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculum = Curriculum::all();
        return response()->json(
            [

                'data' => $curriculum,
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
    public function store(StoreCurriculumRequest $request)
    {
        $curriculum = new Curriculum();
        $curriculum->course_id = $request->course_id;
        $curriculum->curriculum_name = $request->curriculum_name;

        $curriculum->save();

        return response()->json(
            [
                'message' => "curriculum added successfully",
                'data' => $curriculum,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Curriculum $curriculum)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curriculum $curriculum)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurriculumRequest $request, Curriculum $curriculum)
    {

        $curriculum->course_id = $request->course_id;
        $curriculum->curriculum_name = $request->curriculum_name;

        $curriculum->update();

        return response()->json(
            [
                'message' => "curriculum updated successfully",
                'data' => $curriculum,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curriculum $curriculum)
    {

        $curriculum->delete();

        return response()->json(
            [
                'message' => "curriculum deleted successfully",
                'status' => 200
            ],
            200
        );
    }
}
