<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserReview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = UserReview::query();

        if ($request->query('filter') === 'my' && Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->when(Auth::check(), function ($q) {
                $q->where(function ($sub) {
                    $sub->where('status', 1)
                        ->orWhere('user_id', Auth::id());
                });
            }, function ($q) {
                $q->where('status', 1);
            });
        }

        $reviews = $query->latest()->paginate(10);

        return view('frontend.reviews', compact('reviews'));
    }

    public function approve(UserReview $review)
    {
        $review->update(['status' => 1]);

        return redirect()->back()->with('success', 'Review approved successfully!');
    }


    public function create()
    {
        $users = User::all();

        $reviews = UserReview::orderBy('status') 
                            ->latest()
                            ->paginate(10);

        return view('reviews.create', compact('users', 'reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'video_path' => 'required|file|mimes:mp4,mov,avi,webm|max:51200',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('video_path')) {
            $video = $request->file('video_path');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('reviews/videos'), $videoName);
            $videoPath = 'reviews/videos/' . $videoName;
        }


        // Create review
        $review = UserReview::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'video_path' => $videoPath,
            'description' => $request->description,
            'status' => '1', // default status
        ]);

        return redirect()->back()->with([
            'response' => true,
            'msg' => 'রিভিউ সফলভাবে জমা দেওয়া হয়েছে।'
        ]);
    }

    public function storeFromUser(Request $request)
    {
        // dd($request->file('video_path'));
        $validated = $request->validate([
            'title' => 'nullable|string|max:191',
            'video_path' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/webm,video/3gpp,video/x-m4v,application/octet-stream|max:204800',
            'description' => 'nullable|string',
        ], [
            'video_path.mimetypes' => 'Uploaded video format is not supported.',
            'video_path.max' => 'Video file is too large. Maximum allowed size is 200MB.',
        ]);

        $videoPath = null;

        if ($request->hasFile('video_path')) {
            $video = $request->file('video_path');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('reviews/videos'), $videoName);
            $videoPath = 'reviews/videos/' . $videoName;
        }

        UserReview::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'video_path' => $videoPath,
            'description' => $validated['description'] ?? null,
            'status' => '0', 
        ]);

        return redirect()->back()->with([
            'response' => true,
            'msg' => 'রিভিউ সফলভাবে জমা দেওয়া হয়েছে।',
        ]);
    }


    public function update(Request $request, UserReview $review)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'video_path' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
            'description' => 'nullable|string',
        ]);

        // If a new video is uploaded, delete the old one and move the new video
        if ($request->hasFile('video_path')) {
            if ($review->video_path && file_exists(public_path($review->video_path))) {
                unlink(public_path($review->video_path));
            }

            $video = $request->file('video_path');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('reviews/videos'), $videoName);
            $review->video_path = 'reviews/videos/' . $videoName;
        }

        // Update other fields
        $review->title = $request->title;
        $review->description = $request->description;
        $review->save();

        return redirect()->back()->with([
            'response' => true,
            'msg' => 'রিভিউ সফলভাবে আপডেট হয়েছে।'
        ]);
    }

    public function destroy(UserReview $review)
    {
        // Delete video file if exists
        if ($review->video_path && file_exists(public_path($review->video_path))) {
            unlink(public_path($review->video_path));
        }

        $review->delete();

        return redirect()->back()->with([
            'response' => true,
            'msg' => 'রিভিউ মুছে ফেলা হয়েছে।'
        ]);
    }


    public function userReviewUpdate(Request $request, $id)
    {
        $review = UserReview::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video_path' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/webm,video/3gpp,video/x-m4v,application/octet-stream|max:204800',
        ]);

        $review->title = $request->title;
        $review->description = $request->description;

        if ($request->hasFile('video_path')) {
            if ($review->video_path && file_exists(public_path($review->video_path))) {
                unlink(public_path($review->video_path));
            }

            $video = $request->file('video_path');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('reviews/videos'), $videoName);
            $videoPath = 'reviews/videos/' . $videoName;
            $review->video_path = $videoPath;
        }

        $review->status = 0; 
        $review->save();

        return redirect()->back()->with('success', 'রিভিউ সফলভাবে হালনাগাদ করা হয়েছে!');
    }

    public function userReviewDestroy($id)
    {
         $review = UserReview::where('user_id', Auth::id())->findOrFail($id);

        if ($review->video_path && file_exists(public_path($review->video_path))) {
            unlink(public_path($review->video_path));
        }

        $review->delete();

        return redirect()->back()->with([
            'response' => true,
            'msg' => 'রিভিউ মুছে ফেলা হয়েছে।',
        ]);
    }

}
