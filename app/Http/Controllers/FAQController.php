<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFAQRequest;
use App\Http\Requests\UpdateFAQRequest;
use App\Models\FAQ;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $faqs = FAQ::all();
        return response()->json([
            'faq' => $faqs,
            'message' => 'FAQs retrieved successfully',
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
    public function store(StoreFAQRequest $request)
    {
        //
        $faq = new FAQ();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->course_id = $request->course_id;
        $faq->save();
        return response()->json([
            'faq' => $faq,
            'message' => 'FAQ created successfully',
            'status' => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $faq)
    {
        //
        $faq = FAQ::find($faq->id);
        return response()->json([
            'faq' => $faq,
            'message' => 'FAQ retrieved successfully',
            'status' => 200
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFAQRequest $request, FAQ $faq)
    {
        //
        $faq = FAQ::find($faq->id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->course_id = $request->course_id;
        $faq->update();
        return response()->json([
            'faq' => $faq,
            'message' => 'FAQ updated successfully',
            'status' => 200
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $faq)
    {
        //
        $faq = FAQ::find($faq->id);
        $faq->delete();
        return response()->json([
            'message' => 'FAQ deleted successfully',
            'status' => 200
        ]);
    }
}
