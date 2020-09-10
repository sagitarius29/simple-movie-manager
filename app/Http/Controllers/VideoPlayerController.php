<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoPlayerController extends Controller
{
    public function player(Request $request)
    {
        $videoUrl = $request->input('videoUrl');
        $image = $request->input('image');
        return view('layouts.videoplayer')->with(compact('videoUrl', 'image'));
    }
}
