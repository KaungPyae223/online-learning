<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use getID3;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::all();

        return response()->json(
            [

                'data' => $lessons,
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
    public function store(StoreLessonRequest $request)
    {
        $lesson = new Lesson();

        // Video file upload

        $video = $request->file('video');
        $videoName = 'Course_video_' . uniqid() . '.' . $video->getClientOriginalExtension(); // Generate a unique name

        $videoPath = $video->storeAs("videos/course_video", $videoName,"public");

        // Analysis the duration

        $getID3 = new getID3();
        $fileInfo = $getID3->analyze(storage_path('app/public/' . $videoPath));

        if (!isset($fileInfo['playtime_seconds'])) {
            return response()->json(['message' => 'Unable to analyze video'], 400);
        }

        $durationInSeconds = $fileInfo['playtime_seconds'];
        $durationInMinutes = round($durationInSeconds / 60, 0);


        $lesson->curriculum_id = $request->curriculum_id;
        $lesson->lesson_name = $request->lesson_name;
        $lesson->video = asset('storage/'.$videoPath);
        $lesson->duration = $durationInMinutes;

        $lesson->save();

        return response()->json(
            [
                'message' => "lesson added successfully",
                'data' => $lesson,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    // Update lesson video

    public function updateLessonVideo (Request $request){


        $request->validate([
            'video' => 'required|mimes:mp4,avi,mov,mkv|max:500000',
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        if($request->hasFile("video")){

            $video = $request->file("video");
            $lesson_id = $request->lesson_id;

            $lesson = Lesson::find($lesson_id);

            $videoName = 'Course_video_' . uniqid() . '.' . $video->getClientOriginalExtension(); // Generate a unique name
            $videoPath = $video->storeAs("videos/course_video",$videoName,"public");

            $getID3 = new getID3();
            $fileInfo = $getID3->analyze(storage_path('app/public/' . $videoPath));

            if (!isset($fileInfo['playtime_seconds'])) {
                return response()->json(['message' => 'Unable to analyze video'], 400);
            }

            $durationInSeconds = $fileInfo['playtime_seconds'];
            $durationInMinutes = round($durationInSeconds / 60, 0);


            if($lesson->video){
                $old_video_path = str_replace(asset('storage'), '', $lesson->video);
                if (Storage::disk('public')->exists($old_video_path)) {
                    Storage::disk('public')->delete($old_video_path);
                }
            }


            $lesson->video = asset('storage/'.$videoPath);
            $lesson->duration = $durationInMinutes;
            $lesson->update();

            return response()->json([
                'message' => 'Successfully lesson video updated',
                'data' => $lesson
            ], 400);


        }

        return response()->json(['message' => 'No video uploaded'], 400);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {


        $lesson->curriculum_id = $request->curriculum_id;
        $lesson->lesson_name = $request->lesson_name;


        $lesson->update();

        return response()->json(
            [
                'message' => "lesson updated successfully",
                'data' => $lesson,
                'status' => 200
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {

        if($lesson->video){
            $old_video_path = str_replace(asset('storage'), '', $lesson->video);
            if (Storage::disk('public')->exists($old_video_path)) {
                Storage::disk('public')->delete($old_video_path);
            }
        }

        $lesson->delete();

        return response()->json(
            [
                'message' => "lesson deleted successfully",
                'status' => 200
            ],
            200
        );
    }
}
