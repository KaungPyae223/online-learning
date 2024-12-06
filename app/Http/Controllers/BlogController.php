<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use Illuminate\Support\Facades\File;

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
        // $images= [];

        // if($request->blog_image){
        //     foreach($request->file('blog_image') as $image){
        //         $img = 'blog_image' . uniqid() . "." . $image->extension();
        //          $image->storeAs('public/blog_image', $img);
        //         $images[] = $img;
        //     }
        //     $blog->blog_image = json_encode($images);
        // }
        if($request->file('blog_image')){
            $image = $request->file('blog_image');
            $destinationPath = public_path('blog_images');
            $imageName = 'blog_image_' . uniqid() . '.' . $image->extension();
            $image->move($destinationPath, $imageName);
            $blog->blog_image = url('blog_images/' . $imageName);

            if ($blog->blog_image) {
                $oldImagePath = str_replace(url('/'), public_path(), $blog->blog_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

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
        $images= [];

        if($request->blog_image){
            foreach($request->file('blog_image') as $image){
                $img = 'blog_image' . uniqid() . "." . $image->extension();
                 $image->storeAs('public/blog_image', $img);
                $images[] = $img;
            }
            $blog->blog_image = json_encode($images);
        }
        $blog->update();
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
