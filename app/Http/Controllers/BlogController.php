<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blogs = Blog::all();
        return response()->json([
            'blogs' => $blogs,
            'message' => 'Blogs retrieved successfully',
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
    public function store(StoreBlogRequest $request)
    {

        $blog = new Blog();
        $blog->blog_name = $request->blog_name;
        $blog->instructor_id = $request->instructor_id;
        $blog->blog_info = $request->blog_info;
        $blog->blog_content = $request->blog_content;

        if($request->file('blog_image')){
            $image = $request->file('blog_image');
            $imageName = 'blog_image_' . uniqid() . '.' . $image->extension();
            $imagePath = $image->storeAs("images/course_image", $imageName,"public");
            $blog->blog_image = asset('storage/' . $imagePath);
        }
        $blog->save();
        return response()->json([
            'blog' => $blog,
            'message' => 'Blog created successfully',
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
        $blog= Blog::find($blog->id);
        return response()->json([
            'blog' => $blog,
            'message' => 'Blog retrieved successfully',
            'status' => 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    public function updateBlogImage (Request $request){
        $request->validate([
            "image" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
            "id" => "required|exists:blogs,id"
        ]);


        if($request->hasFile("image")){

            $id = $request->id;
            $image = $request->file("image");
            $imageName = 'blog_image_' . uniqid() . '.' . $image->extension();

            $blog = Blog::find($id);

            $imageName = 'blog_image_' . uniqid() . '.' . $image->extension();
            $imagePath = $image->storeAs("images/course_image",$imageName,"public");


            $oldImage = $blog->blog_image;
            $oldImagePath = str_replace(asset('storage'),"",$oldImage);

            if(Storage::disk('public')->exists($oldImagePath)){
                Storage::disk('public')->delete($oldImagePath);
            }

            $blog->blog_image = asset('storage/'.$imagePath);
            $blog->update();

            return response()->json(['message' => 'Image updated successfully!', 'path' => $blog->blog_image], 200);

        }

        return response()->json(['message' => 'No image uploaded'], 400);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        //
        $blog = Blog::find($blog->id);
        $blog->blog_name = $request->blog_name;
        $blog->instructor_id = $request->instructor_id;
        $blog->blog_info = $request->blog_info;
        $blog->blog_content = $request->blog_content;

        return response()->json([
            'blog' => $blog,
            'message' => 'Blog updated successfully',
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
        $blog = Blog::find($blog->id);
        $blog->delete();
        return response()->json([
            'blog' => $blog,
            'message' => 'Blog deleted successfully',
            'status' => 200
        ]);
    }
}
