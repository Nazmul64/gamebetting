<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SliderAdminController extends Controller
{
    /**
     * List all sliders.
     */
    public function index()
    {
        $sliders = Slider::orderBy('order', 'asc')->get();
        return response()->json([
            'success' => true,
            'sliders' => $sliders
        ]);
    }

    /**
     * Store a newly created slider.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:255',
            'prize_text' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive'
        ]);

        $imagePath = $request->input('image_url', 'https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?q=80&w=1200&auto=format&fit=crop');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'slider_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/image/sliders');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            $imagePath = asset('assets/image/sliders/' . $filename);
        }

        $slider = Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'badge_text' => $request->badge_text ?? $request->subtitle,
            'prize_text' => $request->prize_text,
            'button_text' => $request->button_text ?? 'PLAY NOW',
            'button_url' => $request->button_url ?? '/play',
            'image' => $imagePath,
            'bg_gradient' => 'linear-gradient(to right, rgba(10,17,30,0.95) 35%, rgba(10,17,30,0.1) 100%)',
            'order' => (int)($request->order ?? (Slider::count() + 1)),
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Slider banner added successfully!',
            'slider' => $slider
        ]);
    }

    /**
     * Update an existing slider.
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:255',
            'prize_text' => 'nullable|string|max:500',
            'button_text' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:500',
            'order' => 'nullable|integer',
            'status' => 'nullable|in:active,inactive'
        ]);

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'slider_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('assets/image/sliders');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            $slider->image = asset('assets/image/sliders/' . $filename);
        } elseif ($request->filled('image_url')) {
            $slider->image = $request->image_url;
        }

        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->badge_text = $request->badge_text ?? $request->subtitle;
        $slider->prize_text = $request->prize_text;
        $slider->button_text = $request->button_text ?? 'PLAY NOW';
        $slider->button_url = $request->button_url ?? '/play';
        if ($request->filled('order')) {
            $slider->order = (int)$request->order;
        }
        if ($request->filled('status')) {
            $slider->status = $request->status;
        }

        $slider->save();

        return response()->json([
            'success' => true,
            'message' => 'Slider banner updated successfully!',
            'slider' => $slider
        ]);
    }

    /**
     * Toggle slider status between active and inactive.
     */
    public function toggleStatus($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->status = $slider->status === 'active' ? 'inactive' : 'active';
        $slider->save();

        return response()->json([
            'success' => true,
            'message' => 'Slider status changed to ' . $slider->status,
            'status' => $slider->status
        ]);
    }

    /**
     * Delete a slider.
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        $slider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Slider deleted successfully!'
        ]);
    }
}
