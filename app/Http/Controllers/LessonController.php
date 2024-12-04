<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Lesson;
use getID3;
use Illuminate\Support\Facades\File;

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
        $destinationPath = public_path('videos');
        $videoName = 'Course_video_' . uniqid() . '.' . $video->getClientOriginalExtension(); // Generate a unique name

        $video->move($destinationPath, $videoName);

        // Analysis the duration

        $videoPath = $destinationPath . '/' . $videoName;
        $getID3 = new getID3();
        $fileInfo = $getID3->analyze($videoPath);

        if (!isset($fileInfo['playtime_seconds'])) {
            return response()->json(['message' => 'Unable to analyze video'], 400);
        }

        $durationInSeconds = $fileInfo['playtime_seconds'];
        $durationInMinutes = round($durationInSeconds / 60, 0);


        $lesson->curriculum_id = $request->curriculum_id;
        $lesson->lesson_name = $request->lesson_name;
        $lesson->video = url('videos/' . $videoName);
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

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {


        if($request->file('video')){
            $video = $request->file('video');
            $destinationPath = public_path('videos');
            $videoName = 'Course_video_' . uniqid() . '.' . $video->getClientOriginalExtension(); // Generate a unique name

            $video->move($destinationPath, $videoName);

            $videoPath = $destinationPath . '/' . $videoName;
            $getID3 = new getID3();
            $fileInfo = $getID3->analyze($videoPath);

            if (!isset($fileInfo['playtime_seconds'])) {
                return response()->json(['message' => 'Unable to analyze video'], 400);
            }

            $durationInSeconds = $fileInfo['playtime_seconds'];
            $durationInMinutes = round($durationInSeconds / 60, 0);

            $lesson->duration = $durationInMinutes;
            $lesson->video = url('videos/' . $videoName);

            if ($lesson->video) {
                $OldVideoPath = str_replace(url('/'), public_path(), $lesson->video);
                if (File::exists($OldVideoPath)) {
                    File::delete($OldVideoPath);
                }
            }

        }


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
