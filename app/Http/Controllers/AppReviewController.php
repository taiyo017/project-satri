<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\AppReview;
use Illuminate\Http\Request;

class AppReviewController extends Controller
{
    public function index(App $app)
    {
        $reviews = $app->reviews()->latest()->paginate(20);
        return view('admin.apps.reviews.index', compact('app', 'reviews'));
    }

    public function destroy(App $app, AppReview $review)
    {
        $review->delete();
        return redirect()->route('apps.reviews.index', $app)
            ->with('success', 'Review deleted successfully!');
    }

    public function updateStatus(App $app, AppReview $review, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update(['status' => $request->status]);

        return redirect()->route('apps.reviews.index', $app)
            ->with('success', 'Review status updated successfully!');
    }
}
