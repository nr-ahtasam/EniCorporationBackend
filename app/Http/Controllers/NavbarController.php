<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class NavbarController extends Controller
{
    public function form()
    {
        return $this->renderForm();
    }

    public function edit(Navbar $navbar)
    {
        return $this->renderForm($navbar);
    }

    private function renderForm(?Navbar $editNavbar = null)
    {
        $navbars = Navbar::latest()->get();

        return view('admin.navbar', compact('navbars', 'editNavbar'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:11', 'unique:navbars,phone'],
            'image' => ['required', 'image', 'max:2048'],
        ]);

        $imagePath = $request->file('image')->store('navbar', 'public');

        $isActive = !Navbar::where('is_active', true)->exists();

        Navbar::create([
            'phone' => $validated['phone'],
            'image_path' => $imagePath,
            'is_active' => $isActive,
        ]);

        return back()->with('success', 'Navbar data saved successfully.');
    }

    public function update(Request $request, Navbar $navbar)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:11', 'unique:navbars,phone,' . $navbar->id],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $data = [
            'phone' => $validated['phone'],
        ];

        if ($request->hasFile('image')) {
            if ($navbar->image_path) {
                Storage::disk('public')->delete($navbar->image_path);
            }

            $data['image_path'] = $request->file('image')->store('navbar', 'public');
        }

        $navbar->update($data);

        return redirect()->route('navbar.form')->with('success', 'Navbar data updated successfully.');
    }

    public function destroy(Navbar $navbar)
    {
        $wasActive = (bool) $navbar->is_active;

        if ($navbar->image_path) {
            Storage::disk('public')->delete($navbar->image_path);
        }

        $navbar->delete();

        if ($wasActive) {
            $nextNavbar = Navbar::latest()->first();
            if ($nextNavbar) {
                $nextNavbar->update(['is_active' => true]);
            }
        }

        return back()->with('success', 'Navbar row deleted successfully.');
    }

    public function setActive(Navbar $navbar)
    {
        DB::transaction(function () use ($navbar): void {
            Navbar::query()->update(['is_active' => false]);
            $navbar->update(['is_active' => true]);
        });

        return back()->with('success', 'Active navbar updated successfully.');
    }

    public function show()
    {
        $navbar = Navbar::where('is_active', true)->latest()->first() ?? Navbar::latest()->first();

        return response()->json([
            'logo_url' => $navbar ? asset('storage/' . $navbar->image_path) : null,
            'contact_number' => $navbar?->phone,
        ]);
    }
}
