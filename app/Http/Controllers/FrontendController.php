<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.index');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function apply_internal()
    {
        return view('frontend.jobs.apply_internal');
    }
    public function apply()
    {
        return view('frontend.apply');
    }
    public function apply_internal_store(Request $request)
    {
        // Handle the form submission for internal application
        // Validate and process the request data as needed
        // Redirect or return a response
    }
    public function apply_store(Request $request)
    {
        // Handle the form submission for external application
        // Validate and process the request data as needed
        // Redirect or return a response
    }
    public function apply_internal_view()
    {
        return view('frontend.apply_internal_view');
    }
    public function apply_view()
    {
        return view('frontend.apply_view');
    }
    public function apply_internal_view_pdf()
    {
        return view('frontend.apply_internal_view_pdf');
    }
    public function apply_view_pdf()
    {
        return view('frontend.apply_view_pdf');
    }
    public function apply_internal_view_pdf_single()
    {
        return view('frontend.apply_internal_view_pdf_single');
    }
    public function apply_view_pdf_single()
    {
        return view('frontend.apply_view_pdf_single');
    }
    public function apply_internal_view_pdf_single_print()
    {
        return view('frontend.apply_internal_view_pdf_single_print');
    }
    public function apply_view_pdf_single_print()
    {
        return view('frontend.apply_view_pdf_single_print');
    }
}
