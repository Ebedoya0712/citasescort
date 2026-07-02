<?php

namespace App\Http\Controllers;

use App\Models\Escort;
use Illuminate\Http\Request;

class EscortController extends Controller
{
    public function show($id)
    {
        $escort = Escort::with('user', 'reviews', 'stories')->findOrFail($id);
        
        // Similar Escorts: 4 random active escorts excluding current
        $similarEscorts = Escort::where('id', '!=', $id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();
        
        return view('profile.show', compact('escort', 'similarEscorts'));
    }
    public function index(Request $request)
    {
        $query = Escort::where('is_active', true);

        // City Filter
        if ($request->has('city')) {
            $query->where('city', $request->input('city'));
        }
        
        // Department/State Filter
        if ($request->has('state')) {
            $departmentName = $request->input('state');
            // Find department and get its cities
            $department = \App\Models\Department::where('name', $departmentName)->first();
            
            if ($department) {
                $cities = $department->cities->pluck('name')->toArray();
                if (!empty($cities)) {
                    $query->whereIn('city', $cities);
                } else {
                    $query->where('id', 0); 
                }
            }
        }
        
        // Gender Filter
        if ($request->has('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // Currency Filter
        if ($request->has('currency')) {
            $query->where('currency', $request->input('currency'));
        }

        // Filters
        if ($request->has('filter')) {
            $filter = $request->input('filter');
            
            if ($filter === 'diamante' || $filter === 'diamond') {
                $query->where('level', 'diamante');
            } elseif ($filter === 'plata' || $filter === 'silver') {
                $query->where('level', 'plata');
            } elseif ($filter === 'new') {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            // Default sort if no filter selected (Todas) and no specific city
            $query->orderBy('updated_at', 'desc');
        }

        $escorts = $query->with('reviews')->paginate(24)->withQueryString();

        return view('escorts.index', compact('escorts'));
    }
    public function toggleFavorite(Escort $escort)
    {
        auth()->user()->favorites()->toggle($escort->id);
        
        return response()->json([
            'status' => 'success',
            'is_favorite' => auth()->user()->favorites->contains($escort->id)
        ]);
    }
    public function storeReview(Request $request, Escort $escort)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:5',
            'private_content' => 'nullable|string',
            'name' => 'required|string|max:255',
        ]);

        $review = new \App\Models\Review();
        $review->escort_id = $escort->id;
        $review->rating = $validated['rating'];
        $review->content = $validated['content'];
        $review->private_content = $validated['private_content'] ?? null;
        $review->name = $validated['name'];
        $review->is_public = true; // Default to public
        
        if (auth()->check()) {
            $review->user_id = auth()->id();
        }
        
        $review->save();

        return back()->with('success', '¡Gracias por tu opinión! Tu comentario se ha enviado correctamente.');
    }
}
