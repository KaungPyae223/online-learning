<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Repositories\LanguageRepository;

class LanguageController extends Controller
{
    protected $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;;
    }
    /**
     * Display a listing of the resource.
     */
    public function getCoursesByLanguageId($id)
    {

        $language = Language::with('courses')->find($id);

        return response()->json([
            'language' => $language->language,
            'courses' => $language->courses
        ]);
    }

    public function index()
    {
        try {
            $languages = $this->languageRepository->all();

            if ($languages->isEmpty()) {
                return response()->json([
                    'message' => 'No languages found'
                ]);
            }

            return LanguageResource::collection($languages);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve languages',
                'error' => $e->getMessage()
            ]);
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
    public function store(StoreLanguageRequest $request)
    {
        try {
            $language = $this->languageRepository->create($request->all());
            return response()->json([
                'message' => 'Language created successfully',
                'data' => new LanguageResource($language)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create language',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language)
    {
        try {
            $language = $this->languageRepository->find($language->id);
            if (!$language) {
                return response()->json([
                    'message' => 'Language not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Language retrieved successfully',
                'data' => new LanguageResource($language)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve language',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Language $language)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, Language $language)
    {
        try {
            $language = $this->languageRepository->update($language->id, $request->validated());
            return response()->json([
                'message' => 'Language updated successfully',
                'data' => new LanguageResource($language)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update language',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        try {
            $this->languageRepository->delete($language->id);

            if (!$language) {
                return response()->json([
                    'message' => 'Language not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Language deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete language',
                'error' => $e->getMessage()
            ]);
        }
    }
}
