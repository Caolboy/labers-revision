<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $equipments = Equipment::query()
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return response()->json($equipments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'status' => 'required|in:available,unavailable',
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
            $validated['category_id'] = 2;
        }

        $equipment = Equipment::create($validated);

        return response()->json($equipment);
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer',
            'status' => 'required|in:available,unavailable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'image.mimes' => 'Invalid file type. Only jpeg, png, jpg, and gif are allowed.',
            'image.max' => 'File too large. Maximum allowed size is 5MB.',
            'image.image' => 'The uploaded file must be an image.',
        ]);

        if ($request->hasFile('image')) {
            if ($equipment->image) {
                $oldPath = str_replace('storage/', '', $equipment->image); 
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            $path = $request->file('image')->store('images', 'public');
            $validated['image'] = 'storage/' . $path;
        }

        $equipment->update($validated);

        return response()->json($equipment);
    }

    public function destroy(Equipment $equipment)
    {
        if ($equipment->image) {
            $imagePath = str_replace('storage/', '', $equipment->image);

            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $equipment->delete();

        return response()->json(['message' => 'Equipment deleted']);
    }
}