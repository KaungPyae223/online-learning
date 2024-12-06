<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Http\Resources\LevelResource;
use App\Models\Level;
use App\Repositories\LevelRepository;

class LevelController extends Controller
{
    protected $levelRepository;

    public function __construct(LevelRepository $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }
    /**
     * Display a listing of the resource.
     */

    public function getCoursesByLevelId($id)
    {
        try {
            $level = Level::with('courses')->find($id);
            return response()->json([
                'level' => $level->level,
                'courses' => $level->courses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve levels',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function index()
    {
        try {
            $levels = $this->levelRepository->all();

            if ($levels->isEmpty()) {
                return response()->json([
                    'message' => 'No levels found'
                ], 404);
            }

            return LevelResource::collection($levels);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function store(StoreLevelRequest $request)
    {

        try {
            $level =  $this->levelRepository->create($request->validated());
            return response()->json([
                'message' => 'Level created successfully',
                'data' => new LevelResource($level)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create level',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Level $level)
    {
        try {
            if (!$level) {
                return response()->json([
                    'message' => 'Level not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Level retrieved successfully',
                'data' => new LevelResource($level)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve level',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Level $level)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, Level $level)
    {
        try {
            $level = $this->levelRepository->update($level->id, $request->validated());
            return response()->json([
                'message' => 'Level updated successfully',
                'data' => new LevelResource($level)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update level',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level)
    {
        try {
            $this->levelRepository->delete($level->id);
            return response()->json([
                'message' => 'Level deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete level',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
