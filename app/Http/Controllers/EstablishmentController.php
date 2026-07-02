<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;

class EstablishmentController extends Controller
{
    public function index()
    {
        $allEstablishments = Establishment::where('is_active', true)
            ->where('status', 'approved')
            ->get();
        
        $whiskerias = $allEstablishments->where('type', 'whiskeria');
        $massageHouses = $allEstablishments->where('type', 'massage');
        $motels = $allEstablishments->where('type', 'motel');

        return view('establishments.index', compact('allEstablishments', 'whiskerias', 'massageHouses', 'motels'));
    }

    public function show($id)
    {
        // Si el usuario autenticado es el dueño, puede verlo aunque no esté aprobado
        $establishment = Establishment::findOrFail($id);
        
        if (!$establishment->is_active || $establishment->status !== 'approved') {
            if (!auth()->check() || auth()->user()->id !== $establishment->user_id) {
                abort(404);
            }
        }
        
        $establishment->load('reviews.user');
        
        return view('establishments.show', compact('establishment'));
    }

    public function storeReview(Request $request, Establishment $establishment)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
        ]);

        $establishment->reviews()->create([
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'rating' => $request->rating,
            'content' => $request->content,
            'is_public' => true,
        ]);

        return back()->with('success', '¡Gracias por tu reseña!');
    }
}
