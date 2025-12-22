<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionTopicController extends Controller
{
    public function index()
    {
        $topics = SubscriptionTopic::withCount('subscribers')->get();
        return view('admin.subscription-topics.index', compact('topics'));
    }

    public function create()
    {
        return view('admin.subscription-topics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:subscription_topics,slug',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        SubscriptionTopic::create($validated);

        return redirect()->route('admin.subscription-topics.index')
            ->with('success', 'Topic created successfully.');
    }

    public function edit(SubscriptionTopic $subscriptionTopic)
    {
        return view('admin.subscription-topics.edit', compact('subscriptionTopic'));
    }

    public function update(Request $request, SubscriptionTopic $subscriptionTopic)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:subscription_topics,slug,' . $subscriptionTopic->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $subscriptionTopic->update($validated);

        return redirect()->route('admin.subscription-topics.index')
            ->with('success', 'Topic updated successfully.');
    }

    public function destroy(SubscriptionTopic $subscriptionTopic)
    {
        $subscriptionTopic->delete();

        return redirect()->route('admin.subscription-topics.index')
            ->with('success', 'Topic deleted successfully.');
    }
}
