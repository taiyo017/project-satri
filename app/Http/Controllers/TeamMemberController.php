<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index(Request $request)
    {
        $query = TeamMember::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Designation filter
        if ($request->filled('designation')) {
            $query->where('designation', $request->designation);
        }

        $members = $query->orderBy('order_index')->paginate(10)->withQueryString();
        
        // Get unique designations for filter dropdown
        $designations = TeamMember::whereNotNull('designation')
            ->distinct()
            ->pluck('designation')
            ->sort();
        
        return view('admin.teams.index', compact('members', 'designations'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'designation'     => 'nullable|string|max:255',
            'bio'             => 'nullable|max:255',
            'message'         => 'nullable|string',
            'photo'           => 'nullable|image|max:2048',
            'social_links'    => 'nullable|array',
            'order_index'     => 'nullable|integer',
            'meta_title'      => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'   => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()
            ->route('team-members.index')
            ->with('success', 'Team member added successfully.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('admin.teams.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'designation'     => 'nullable|string|max:255',
            'bio'             => 'nullable|max:255',
            'message'         => 'nullable|string',
            'photo'           => 'nullable|image|max:2048',
            'social_links'    => 'nullable|array',
            'order_index'     => 'nullable|integer',
            'meta_title'      => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'   => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            if ($teamMember->photo && Storage::disk('public')->exists($teamMember->photo)) {
                Storage::disk('public')->delete($teamMember->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember->update($data);

        return redirect()
            ->route('team-members.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->photo && Storage::disk('public')->exists($teamMember->photo)) {
            Storage::disk('public')->delete($teamMember->photo);
        }

        $teamMember->delete();

        return back()->with('success', 'Team member deleted successfully.');
    }
}
