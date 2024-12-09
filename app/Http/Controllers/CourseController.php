<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\map;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with('category','level','language','instructor','curriculum','review')->where('is_public',false)->get()->map(function($course){

            // Calculate total duration

            $totalMinute = $course->curriculum
            ? $course->curriculum->flatMap->lesson->sum('duration')
            : 0;

            $hours = (int) ($totalMinute/60);
            $minutes = $totalMinute%60;
            $duration =  ($hours>0? $hours . "hr " : "") . $minutes. "min";

            $total_lesson = $course->curriculum
            ? $course->curriculum->flatMap->lesson->count():0;


            // Calculate average rating


            $average_rating = round($course->review? $course->review->average('rating'):0, 1);

            // total students

            $total_student = $course->user? $course->user->count("id"):0;

            return [
                "id"=>$course->id,
                "course_name"=>$course->course_name,
                "course_image"=>$course->course_image,
                "total_student"=>$total_student,
                "price"=>$course->price,
                "total_duration"=>$duration,
                "total_lessons"=>$total_lesson,
                "average_rating"=>$average_rating,
                "category"=>$course->category->category,
                "level"=>$course->level->level,
                "language"=>$course->language->language,
                "instructor_name"=>$course->instructor->name,
                "instructor_profile"=>$course->instructor->instructor_image,
            ];
        });
        return response()->json(
            [
                'data' => $courses,
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
    public function store(StoreCourseRequest $request)
    {

        $course  = new Course();

        $image = $request->file('course_image');
        $imageName = 'Course_image_' . uniqid() . '.' . $image->extension();
        $image->storeAs("images/course_image", $imageName,"public");

        $course->course_image = asset('storage/' . $imageName);



        $course->course_name = $request->name;
        $course->course_info = $request->info;
        $course->price = $request->price;
        $course->course_description = $request->description;
        $course->can_learn = json_encode($request->can_learn);
        $course->skill_gain = json_encode($request->skill_gain);
        $course->category_id = $request->category_id;
        $course->level_id=$request->level_id;
        $course->language_id = $request->language_id;
        $course->instructor_id = $request->instructor_id;

        $course->save();
        return response()->json(
            [
                'message' => 'Course added successfully',
                'data' => $course,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        // Calculate total duration

        $totalMinute = $course->curriculum
        ? $course->curriculum->flatMap->lesson->sum('duration')
        : 0;

        $hours = (int) ($totalMinute/60);
        $minutes = $totalMinute%60;
        $duration = ($hours>0? $hours . "hr " : "") . $minutes. "min";

        $total_lesson = $course->curriculum
        ? $course->curriculum->flatMap->lesson->count():0;


        // Calculate average rating

        $average_rating = round($course->review? $course->review->average('rating'):0, 1);

        // total students

        $total_student = $course->user? $course->user->count("id"):0;

        // review details

        $review_data = $course->review->map(function($data){
            return [
                "reviewer_name" => $data->user->name,
                "reviewer_profile" => $data->user->user_photo,
                "review_content" => $data->review,
                "rating" => $data->rating,
                "review_date" => $data->created_at
            ];
        });

        $max_count = $course->review()
        ->select(DB::raw('COUNT(id) as count'))
        ->groupBy('rating')
        ->pluck('count')
        ->max();

        function Calculate_percentage ($rating,$max_count) {
            if ($max_count === 0) {
                return 0; // Avoid division by zero
            }
            return (int) (($rating / $max_count) * 100);
        }

        $rating_count = [
            "5_stars" => Calculate_percentage($course->review()->where("rating", 5)->count(),$max_count),
            "4_stars" => Calculate_percentage($course->review()->where("rating", 4)->count(),$max_count),
            "3_stars" => Calculate_percentage($course->review()->where("rating", 3)->count(),$max_count),
            "2_stars" => Calculate_percentage($course->review()->where("rating", 2)->count(),$max_count),
            "1_stars" => Calculate_percentage($course->review()->where("rating", 1)->count(),$max_count),
        ];

        $review = [
            "rating_count"=>$rating_count,
            "review_data"=>$review_data
        ];

        // faq details

        $faqs = $course->faq->map(function($data){
            return [
               "question" => $data->question,
               "answer" => $data->answer,
            ];
        });

        // curriculum details

        function time_convert ($duration){
            $hours = $duration/60;
            $minutes = $duration%60;
            return ($hours>0? $hours . "hr " : "") . $minutes. "min";
        }

        $curriculum = $course->curriculum->map(function($data){
            return [
                "curriculum_name" => $data->curriculum_name,
                "total_lessons" => $data->lesson->count(),
                "lessons" => $data->lesson->map(function($lesson){
                    return [
                        "lesson_name" => $lesson->lesson_name,
                        "video" => $lesson->video,
                        "duration" => time_convert($lesson->duration)
                    ];
                })
            ];
        });

        // Instructor

        $instructor_courses = $course->instructor->course->count();
        $instructor_students = $course->instructor->course->flatMap->user->count();

        $instructor_rating = round($course->instructor->course->flatMap->review->average('rating'),1);

        $instructor = [
            "instructor_name" => $course->instructor->name,
            "instructor_type" => $course->instructor->type,
            "instructor_photo" => $course->instructor->instructor_image,
            "X" => $course->instructor->X,
            "facebook" => $course->instructor->facebook,
            "instagram" => $course->instructor->instagram,
            "linkedIn" => $course->instructor->linkedIn,
            "total_instructor_courses" => $instructor_courses,
            "total_instructor_students" => $instructor_students,
            "instructor_rating" => $instructor_rating,
        ];

        $course_details = [
            "id"=>$course->id,
            "course_name"=>$course->course_name,
            "total_student"=>$total_student,
            "price"=>$course->price,
            "description"=>$course->course_description,
            "info"=>$course->course_info,
            "can_learn"=>json_decode($course->can_learn),
            "skill_gain"=>json_decode($course->skill_gain),
            "total_duration"=>$duration,
            "total_lessons"=>$total_lesson,
            "average_rating"=>$average_rating,
            "category"=>$course->category->category,
            "level"=>$course->level->level,
            "language"=>$course->language->language,
            "curriculum"=>$curriculum,
            "instructor"=>$instructor,
            "reviews"=>$review,
            "faqs"=>$faqs,
        ];

        return response()->json(
            [
                'data' => $course_details,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'course_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'required|exists:courses,id'
        ]);

        if ($request->hasFile('course_image')) {
            $image = $request->file('course_image');
            $course_id = $request->course_id;

            // Retrieve the course
            $course = Course::find($course_id);

            // Define the image name and store the image
            $imageName = 'Course_image_' . uniqid() . '.' . $image->extension();
            $imagePath = $image->storeAs('images/course_image', $imageName, 'public'); // Store in 'storage/app/public/images/course_image'

            // Delete the old image if it exists
            if ($course->course_image) {
                $oldImagePath = str_replace(asset('storage'), '', $course->course_image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            // Update the course with the new image URL
            $course->course_image = asset('storage/' . $imagePath); // Generate correct URL
            $course->update();

            // Return a success response
            return response()->json(['message' => 'Image updated successfully!', 'path' => $course->course_image], 200);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {

        $course->course_name = $request->name;
        $course->course_info = $request->info;
        $course->price = $request->price;
        $course->course_description = $request->description;
        $course->can_learn = json_encode($request->can_learn);
        $course->skill_gain = json_encode($request->skill_gain);
        $course->category_id = $request->category_id;
        $course->level_id=$request->level_id;
        $course->language_id = $request->language_id;
        $course->instructor_id = $request->instructor_id;
        $course->is_public = $request->is_public;
        $course->update();
        return response()->json(
            [
                'message' => 'Course updated successfully',
                'data' => $course,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {

        if ($course->course_image) {
            $oldImagePath = str_replace(asset('storage'), '', $course->course_image);

            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $course->delete();

        return response()->json(
            [
                'message' => 'Course deleted successfully',
                'status' => 200
            ],
            200
        );
    }
}
