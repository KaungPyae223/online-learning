<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Course;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function searchAndFilter(Request $request)
    {

        try {
            $filters = $request->only([
                'query',
                'order_by',
                'sort',
                'limit',
                'filter'
            ]);
            $users = $this->userRepository->searchAndFilter($filters);
            return UserResource::collection($users);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        };
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->userRepository->all();

            if ($users->isEmpty()) {
                return response()->json([
                    'message' => 'No users found'
                ], 404);
            }

            return UserResource::collection($users);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve users',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'nullable|string|in:instructor,student',
            'phone' => 'nullable|string|max:15',
            'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {

            if ($request->hasFile('user_photo')) {
                $userPhoto = $request->file('user_photo');
                $photoName = time() . $userPhoto->getClientOriginalName() . '.' . $userPhoto->getClientOriginalExtension();
                $userPhoto->storeAs('images/usersPhoto', $photoName, 'public');
                $validatedUser['user_photo'] = $photoName;
            }
            $user = $this->userRepository->create($validatedUser);

            return response()->json([
                'message' => 'User created successfully',
                'data' => new UserResource($user)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create user',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);

            if ($user) {
                return response()->json([
                    'message' => 'User retrieved successfully',
                    'data' => new UserResource($user)
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request;
        $validatedUser = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'user_type' => 'nullable|string|in:instructor,student',
            'phone' => 'nullable|string|max:15',
            'user_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        try {

            if (!empty($validatedUser['password'])) {
                $validatedUser['password'] = bcrypt($validatedUser['password']);
            }


            if ($request->hasFile('user_photo')) {
                $photo = $request->file('user_photo');
                $photoName = time() . '.' . $photo->getClientOriginalExtension();

                $photo->storeAs('images/usersPhoto', $photoName, 'public');
                $validatedUser['user_photo'] = $photoName;
            }

            $user = $this->userRepository->update($id, $validatedUser);
            return response()->json([
                'message' => 'User updated successfully',
                'data' => new UserResource($user),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->userRepository->delete($id);

            if ($user) {
                return response()->json([
                    'message' => 'User deleted successfully',
                    'data' => new UserResource($user)
                ], 200);
            } else {
                return response()->json([
                    'message' => 'User not found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function userReviews(string $id)
    {
        try {
            $user = User::with('reviews')->find($id);

            if (!$user) {
                return response()->json([
                    'message' => "User's reviews not found",
                ], 404);
            }

            return response()->json([
                'message' => "User's reviews retrieved successfully",
                'data' => [
                    'reviews' => $user->reviews
                ],
                'statisics' => [
                    'average_rating' => $user->reviews->avg('rating'),
                    'total_reviews' => $user->reviews->count(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve user reviews',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function enrollment(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);
        try {
            $user = User::find($id);
            $courseId = $request->course_id;
            $course = Course::find($courseId);

            if ($user->courses()->where('id', $courseId)->exists()) {
                return response()->json([
                    'message' => 'You are already enrolled in this course',
                ], 200);
            }
            $user->courses()->attach($courseId);

            return response()->json([
                'message' => 'Course enrolled successfully',
                'course' => [
                    'id' => $courseId,
                    'course_title' => $course->title,
                    'course_description' => $course->description,
                    'can_learn' => $course->can_learn,
                    'skill_gain' => $course->skill_gain,
                    'price' => $course->price,
                    'course_image' => $course->course_image ?? null
                ],
                'user' => new UserResource($user)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to enroll course',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function unenrollment(Request $request, string $id)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id'
        ]);
        try {
            $user = User::find($id);
            $courseId = $request->course_id;
            $course = Course::find($courseId);

            if (!$user->courses()->where('id', $courseId)->exists()) {
                return response()->json([
                    'message' => 'You are not enrolled in this course',
                ], 200);
            }
            $user->courses()->detach($courseId);

            return response()->json([
                'message' => 'Course unenrolled successfully',
                'course' => [
                    'id' => $courseId,
                    'course_title' => $course->title,
                    'course_description' => $course->description,
                    'can_learn' => $course->can_learn,
                    'skill_gain' => $course->skill_gain,
                    'price' => $course->price,
                    'course_image' => $course->course_image ?? null
                ],
                'user' => new UserResource($user)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to unenroll course',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function photoChange(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'user_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::find($validated['user_id']);

        try {

            if ($request->hasFile('user_photo')) {
                $photo = $request->file('user_photo');
                $photoName = time() . '.' . $photo->getClientOriginalExtension();
                $photo->storeAs('images/usersPhoto', $photoName, 'public');


                if ($user->user_photo) {
                    Storage::delete('images/usersPhoto/' . $user->user_photo, 'public');
                }


                $user->user_photo = $photoName;
                $user->save();
            }

            return response()->json([
                'message' => 'Photo updated successfully',
                'data' => new UserResource($user),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update photo',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
