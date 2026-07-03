<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function show($id)
    {
        $publication = Publication::with('escort.user', 'escort.reviews', 'escort.stories')->findOrFail($id);
        $escort = $publication->escort;

        // Incrementar el contador de vistas
        if ($escort) {
            $escort->increment('views_count');
        }

        return view('publications.show', compact('publication', 'escort'));
    }
}
