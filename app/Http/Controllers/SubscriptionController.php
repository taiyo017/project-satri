<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\SubscriptionTopic;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(
        private SubscriptionService $subscriptionService
    ) {}

    public function showForm()
    {
        $topics = SubscriptionTopic::active()->get();
        return view('subscription.form', compact('topics'));
    }

    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
            'topics' => 'required|array|min:1',
            'topics.*' => 'exists:subscription_topics,id',
        ]);

        $subscriber = $this->subscriptionService->subscribe(
            $validated['email'],
            $validated['topics'],
            $validated['name'] ?? null,
            $request->ip(),
            $request->userAgent()
        );

        return redirect()->route('subscription.pending')
            ->with('success', 'Please check your email to verify your subscription.');
    }

    public function pending()
    {
        return view('subscription.pending');
    }

    public function verify(string $token)
    {
        \Log::info('Subscription verification attempt', [
            'token' => $token,
            'token_length' => strlen($token)
        ]);
        
        $subscriber = $this->subscriptionService->verify($token);
        
        \Log::info('Subscription verification result', [
            'found' => $subscriber ? 'yes' : 'no',
            'email' => $subscriber?->email,
            'status' => $subscriber?->status
        ]);

        if (!$subscriber) {
            \Log::warning('Verification failed - subscriber not found or already verified');
            return redirect()->route('subscription.form')
                ->with('error', 'Invalid or expired verification link.');
        }

        return view('subscription.verified', compact('subscriber'));
    }

    public function unsubscribe(string $token)
    {
        $subscriber = $this->subscriptionService->unsubscribe($token);

        if (!$subscriber) {
            return redirect()->route('home')
                ->with('error', 'Invalid unsubscribe link.');
        }

        return view('subscription.unsubscribed', compact('subscriber'));
    }

    public function preferences(string $token)
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->firstOrFail();
        $topics = SubscriptionTopic::active()->get();
        $subscribedTopicIds = $subscriber->topics->pluck('id')->toArray();

        return view('subscription.preferences', compact('subscriber', 'topics', 'subscribedTopicIds'));
    }

    public function updatePreferences(Request $request, string $token)
    {
        $subscriber = Subscriber::where('unsubscribe_token', $token)->firstOrFail();

        $validated = $request->validate([
            'topics' => 'required|array|min:1',
            'topics.*' => 'exists:subscription_topics,id',
        ]);

        $this->subscriptionService->updatePreferences($subscriber, $validated['topics']);

        return redirect()->route('subscription.preferences', $token)
            ->with('success', 'Your preferences have been updated.');
    }
}
