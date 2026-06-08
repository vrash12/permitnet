<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\OrganizationMember;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        if (! session('is_logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $members = OrganizationMember::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $ceo = OrganizationMember::whereNull('parent_id')
            ->orderBy('sort_order')
            ->first();

        $admins = collect();
        $staff = collect();

        if ($ceo) {
            $admins = OrganizationMember::where('parent_id', $ceo->id)
                ->orderBy('sort_order')
                ->get();

            $staff = OrganizationMember::whereIn('parent_id', $admins->pluck('id'))
                ->orderBy('sort_order')
                ->get();
        }

        return view('organization.index', compact(
            'members',
            'ceo',
            'admins',
            'staff'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'contact' => ['nullable', 'string', 'max:100'],
            'street' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:organization_members,id'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        OrganizationMember::create($data);

        return redirect()
            ->route('organization.index')
            ->with('success', 'Organization member created successfully.');
    }

    public function show(OrganizationMember $member)
    {
        if (! session('is_logged_in')) {
            return redirect()->route('login')
                ->with('error', 'Please login first.');
        }

        $devices = Device::where('owner_name', $member->name)
            ->latest()
            ->get();

        return view('organization.show', [
            'member' => $member,
            'devices' => $devices,
        ]);
    }

    public function update(Request $request, OrganizationMember $member)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:100'],
            'contact' => ['nullable', 'string', 'max:100'],
            'street' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:organization_members,id'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if (! empty($data['parent_id']) && (int) $data['parent_id'] === (int) $member->id) {
            return back()->withErrors([
                'parent_id' => 'A member cannot be their own parent.',
            ]);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        $member->update($data);

        return redirect()
            ->route('organization.index')
            ->with('success', 'Organization member updated successfully.');
    }

    public function destroy(OrganizationMember $member)
    {
        $member->delete();

        return redirect()
            ->route('organization.index')
            ->with('success', 'Organization member deleted successfully.');
    }
}