<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    //
    public function index()
    {

        $title = 'Section CMS';
        return view('backend.section', compact('title'));
    }

    public function store(Request $request)
    {

        if ($request->isMethod('post')) {

            $datas = $request->key;

            foreach ($datas as $data) {
                foreach ($data as $key => $value) {
                    if (Section::where('key', $key)->first()) {
                        $section =  Section::where('key', $key)->first();
                    } else {
                        $section = new Section();
                    }
                    $section->key = $key;
                    $section->value = $value;
                    $section->save();
                }
            }
            $files = $request->file;
            if ($files) {
                foreach ($files as $file) {
                    foreach ($file as $key => $value) {

                        if (Section::where('key', $key)->first()) {
                            $section =  Section::where('key', $key)->first();
                        } else {
                            $section = new Section();
                        }
                        $section->key = $key;
                        $section->value = imageUpload($value);
                        $section->save();

                    }
                }
            }

            if ($request->hasFile('slider_image')) {

                if (Section::where('key', 'slider_image')->first()) {
                    $section =  Section::where('key', 'slider_image')->first();
                } else {
                    $section = new Section();
                }
                $section->key = 'slider_image';
                $section->value = imageUpload($request->slider_image);
                $section->save();
            }

            if ($request->hasFile('aboutus_image')) {
                if (Section::where('key', 'aboutus_image')->first()) {
                    $section =  Section::where('key', 'aboutus_image')->first();
                } else {
                    $section = new Section();
                }
                $section->key = 'aboutus_image';
                $section->value = imageUpload($request->aboutus_image);
                $section->save();
            }

            if ($request->hasFile('footer_image')) {
                if (Section::where('key', 'footer_image')->first()) {
                    $section =  Section::where('key', 'footer_image')->first();
                } else {
                    $section = new Section();
                }
                $section->key = 'footer_image';
                $section->value = imageUpload($request->footer_image);
                $section->save();
            }

            return back()->with(['response' => true, 'msg' => 'Section update Success']);
        }
    }
}
