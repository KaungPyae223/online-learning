<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $instructors = Instructor::all();

        // return apiResponse($instructors, 'Instructors retrieved successfully', 200);
        return response()->json([
            'instructors' => $instructors,
            'message' => 'Instructors retrieved successfully',
            'status' => 200
        ]);
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
    public function store(StoreInstructorRequest $request)
    {
        //
        $instructor = new Instructor();
        $instructor->name = $request->name;
        $instructor->info = $request->info;
        $instructor->type = $request->type;
        if($request->file('instructor_image')){
            $image = $request->file('instructor_image');

            $imageName = 'instructor_image_' . uniqid() . '.' . $image->extension();
            $imagePath = $image->storeAs("images/instructor_images", $imageName,"public");
            $instructor->instructor_image = asset("storage/".$imagePath);

        }

        $instructor->facebook = $request->facebook;
        $instructor->instagram = $request->instagram;
        $instructor->linkedIn = $request->linkedIn;
        $instructor->X = $request->X;
        $instructor->save();
        // return apiResponse($instructor, 'Instructor created successfully', 200);
        return response()->json([
            'instructor' => $instructor,
            'message' => 'Instructor created successfully',
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        //
        $instructor = Instructor::find($instructor->id);
        // return apiResponse($instructor, 'Instructor retrieved successfully', 200);
        return response()->json([
            'instructor' => $instructor,
            'message' => 'Instructor retrieved successfully',
            'status' => 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        //
    }

    public function instructorImageUpdate(Request $request){
        $request->validate([
            "instructor_image"=>"required|image|mimes:jpeg,png,jpg,gif|max:2048",
            "instructor_id" => "required|exists:instructors,id"
        ]);

        if($request->hasFile("instructor_image")){

            $image = $request->file("instructor_image");
            $id = $request->instructor_id;

            $imageName = 'instructor_image_' . uniqid() . '.' . $image->extension();
            $imagePath = $image->storeAs("images/instructor_images", $imageName,"public");


            $instructor = Instructor::find($id);
            $oldImage = $instructor->instructor_image;
            $oldImagePath = str_replace(asset("storage"),"",$oldImage);

            if(Storage::disk("public")->exists($oldImagePath)){
                Storage::disk("public")->delete($oldImagePath);
            }

            $instructor->instructor_image = asset("storage/".$imagePath);
            $instructor->update();

            return response()->json(['message' => 'Image updated successfully!', 'path' => $course->course_image], 200);

        }

        return response()->json(['message' => 'No image uploaded'], 400);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructorRequest $request, Instructor $instructor)
    {
        //

        $instructor = Instructor::find($instructor->id);
        $instructor->name = $request->name;
        $instructor->info = $request->info;
        $instructor->type = $request->type;
        $instructor->facebook = $request->facebook;
        $instructor->instagram = $request->instagram;
        $instructor->linkedIn = $request->linkedIn;
        $instructor->X = $request->X;
        $instructor->update();
        // return apiResponse($instructor, 'Instructor updated successfully', 200);
        return response()->json([
            'instructor' => $instructor,
            'message' => 'Instructor updated successfully',
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        //
        $instructor = Instructor::find($instructor->id);
        if ($instructor) {
            $instructor->delete();
            // return apiResponse($instructor, 'Instructor deleted successfully', 200);
            return response()->json([
                'instructor' => $instructor,
                'message' => 'Instructor deleted successfully',
                'status' => 200
            ]);
        }
    }
}
