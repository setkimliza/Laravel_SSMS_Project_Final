<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->filled('search')) {
            $query->where('UserName', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('role')) {
            $query->where('Role', $request->role);
        }

        $staffList = $query->orderBy('Sid', 'desc')->paginate(10)->withQueryString();

        return view('admin.staff.index', compact('staffList'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'UserName' => ['required', 'string', 'max:50', 'unique:staff,UserName'],
            'Password' => ['required', 'string', 'min:6'],
            'Role' => ['required', Rule::in(['Admin', 'Stock'])],
        ]);

        Staff::create([
            'UserName' => $validated['UserName'],
            'Password' => Hash::make($validated['Password']),
            'Role' => $validated['Role'],
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff account created successfully!');
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'UserName' => ['required', 'string', 'max:50', Rule::unique('staff', 'UserName')->ignore($staff->Sid, 'Sid')],
            'Password' => ['nullable', 'string', 'min:6'],
            'Role' => ['required', Rule::in(['Admin', 'Stock'])],
        ]);

        $staff->UserName = $validated['UserName'];
        $staff->Role = $validated['Role'];

        if (!empty($validated['Password'])) {
            $staff->Password = Hash::make($validated['Password']);
        }

        $staff->save();

        return redirect()->route('admin.staff.index')->with('success', 'Staff account updated successfully!');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        // Prevent self deletion
        if (Auth::guard('staff')->id() == $staff->Sid) {
            return back()->with('error', 'Action denied: You cannot delete your own logged-in admin account.');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff account deleted successfully.');
    }
}
