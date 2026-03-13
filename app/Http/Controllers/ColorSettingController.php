<?php

namespace App\Http\Controllers;

use App\Models\ColorSetting;
use Illuminate\Http\Request;

class ColorSettingController extends Controller
{
    public function index()
    {
        // Fetch the first color setting or create a default if no data exists
        $colors = ColorSetting::first();
        
        // If no data exists, create a new empty record
        if (!$colors) {
            $colors = new ColorSetting([
                'body_color' => '#ffffff', 
                'header_color' => '#067fab', 
                'footer_color' => '#333333', 
                'headings_color' => '#000000', 
                'heading_background_color' => '#000000', 
                'label_color' => '#000000', 
                'paragraph_color' => '#000000'
            ]);
        }

        return view('backend.colors', compact('colors'));
    }


    public function update(Request $request)
{
    $request->validate([
        'body_color' => 'required|string|size:7',
        'header_color' => 'required|string|size:7',
        'footer_color' => 'required|string|size:7',
        'headings_color' => 'required|string|size:7',
        'label_color' => 'required|string|size:7',
        'paragraph_color' => 'required|string|size:7',
    ]);

    $colors = ColorSetting::first();

    // Check if no colors exist and create a new one if necessary
    if (!$colors) {
        $colors = new ColorSetting([
            'body_color' => $request->input('body_color'),
            'header_color' => $request->input('header_color'),
            'footer_color' => $request->input('footer_color'),
            'headings_color' => $request->input('headings_color'),
            'heading_background_color' => $request->input('heading_background_color'),
            'label_color' => $request->input('label_color'),
            'paragraph_color' => $request->input('paragraph_color'),
        ]);
        $colors->save();  // Save the new record
    } else {
        // Update existing record
        $colors->update([
            'body_color' => $request->input('body_color'),
            'header_color' => $request->input('header_color'),
            'footer_color' => $request->input('footer_color'),
            'headings_color' => $request->input('headings_color'),
            'heading_background_color' => $request->input('heading_background_color'),
            'label_color' => $request->input('label_color'),
            'paragraph_color' => $request->input('paragraph_color'),
        ]);
    }

    return redirect()->route('admin.colors.index')->with('success', 'Colors updated successfully!');
}

}
