<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Repositories\ReviewRepository;

class ReviewController extends Controller
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $reviews = $this->reviewRepository->all();

            if ($reviews->isEmpty()) {
                return response()->json([
                    'message' => 'No reviews found'
                ], 404);
            }
            return ReviewResource::collection($reviews);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve reviews',
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
    public function store(StoreReviewRequest $request)
    {
        try {

            $review = $this->reviewRepository->create($request->validated());
            return response()->json([
                'message' => 'Review created successfully',
                'data' => new ReviewResource($review)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create review',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        try {
            $review = $this->reviewRepository->find($review->id);
            if (!$review) {
                return response()->json([
                    'message' => 'Review not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Review retrieved successfully',
                'data' => new ReviewResource($review)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve review',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        try {
            $review = $this->reviewRepository->update($review->id, $request->validated());
            return response()->json([
                'message' => 'Review updated successfully',
                'data' => new ReviewResource($review)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update review',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        try {
            $review = $this->reviewRepository->delete($review->id);
            return response()->json([
                'message' => 'Review deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete review',
                'error' => $e->getMessage()
            ]);
        }
    }
}
