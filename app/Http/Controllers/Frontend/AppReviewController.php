<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\AppReview;
use Illuminate\Http\Request;

class AppReviewController extends Controller
{
    public function store(Request $request, $slug)
    {
        $app = App::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        try {
            $validated = $request->validate([
                'reviewer_name' => 'required|string|max:255',
                'reviewer_email' => 'required|email|max:255',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|min:10|max:1000',
            ]);

            AppReview::create([
                'app_id' => $app->id,
                'reviewer_name' => $validated['reviewer_name'],
                'reviewer_email' => $validated['reviewer_email'],
                'rating' => $validated['rating'],
                'review' => $validated['review'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! It will be published after approval.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred. Please try again.',
            ], 500);
        }
    }
}
