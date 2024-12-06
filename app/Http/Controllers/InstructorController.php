<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstructorRequest;
use App\Http\Requests\UpdateInstructorRequest;
use App\Models\Instructor;
use Illuminate\Support\Facades\File;

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
            $destinationPath = public_path('instructor_images');
            $imageName = 'instructor_image_' . uniqid() . '.' . $image->extension();
            $image->move($destinationPath, $imageName);
            $instructor->instructor_image = url('instructor_images/' . $imageName);

            if ($instructor->instructor_image) {
                $oldImagePath = str_replace(url('/'), public_path(), $instructor->instructor_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

        }

        // if ($request->instructor_image) {
        //     $instructorImage = $request->file('instructor_image');
        //     $instructorImageName = 'instructor_image' . uniqid() . "." . $instructorImage->extension();
        //     $instructorImage->storeAs('public/instructor_images', $instructorImageName);
        //     $instructor->instructor_image = json_encode($instructorImageName);
        // }
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
        if ($request->instructor_image) {
            $instructorImage = $request->file('instructor_image');
            $instructorImageName = 'instructor_image' . uniqid() . "." . $instructorImage->extension();
            $instructorImage->storeAs('public/instructor_images', $instructorImageName);
            $instructor->instructor_image = json_encode($instructorImageName);
        }else{
            $instructor->instructor_image = $instructor->instructor_image;
        }
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
