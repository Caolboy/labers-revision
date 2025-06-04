<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $labs = Lab::query() 
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return response()->json($labs); 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'category_id' => 'nullable|integer',
        ], [
            'image.mimes' => 'Invalid file type. Only jpeg, png, jpg, and gif are allowed.',
            'image.max' => 'File too large. Maximum allowed size is 5MB.',
            'image.image' => 'The uploaded file must be an image.',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        if (!isset($validated['category_id'])) {
            $validated['category_id'] = 1;
        }

        $lab = Lab::create($validated);

        return response()->json($lab);
    }

    public function update(Request $request, Lab $lab)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'image.mimes' => 'Invalid file type. Only jpeg, png, jpg, and gif are allowed.',
            'image.max' => 'File too large. Maximum allowed size is 5MB.',
            'image.image' => 'The uploaded file must be an image.',
        ]);

        if ($request->hasFile('image')) {
            if ($lab->image) {
                $oldPath = str_replace('storage/', '', $lab->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $lab->update($validated);

        return response()->json($lab);
    }

    public function destroy(Lab $lab)
    {
        if ($lab->image) {
            $imagePath = str_replace('storage/', '', $lab->image);
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $lab->delete();

        return response()->json(['message' => 'Lab deleted']);
    }
}