<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Afficher la liste des annonces publiques avec recherche et filtrage.
     */
    public function indexPublic(Request $request)
    {
        $query = Annonce::where('statut', 'active');

        // Filtrer par type (perdu/retrouvé)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrer par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // Filtrer par lieu
        if ($request->filled('lieu')) {
            $query->where('lieu', 'like', '%' . $request->lieu . '%');
        }

        // Filtrer par date (par exemple, annonces publiées après une certaine date)
        if ($request->filled('date')) {
            $query->whereDate('date', '>=', $request->date);
        }

        $annonces = $query->paginate(10)->withQueryString();
        $categories = Categorie::all(); // Pour le formulaire de filtrage

        return view('annonces.index', compact('annonces', 'categories'));
    }

    /**
     * Afficher une annonce publique spécifique.
     */
    public function showPublic($id)
    {
        $annonce = Annonce::findOrFail($id);
        return view('annonces.show', compact('annonce'));
    }

    /**
     * Afficher la liste des annonces pour l'utilisateur connecté avec recherche et filtrage.
     */
    public function index(Request $request)
    {
        $query = Annonce::where('user_id', Auth::id());

        // Filtrer par type (perdu/retrouvé)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtrer par catégorie
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        // Filtrer par statut (active/résolue/en attente)
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $annonces = $query->paginate(10)->withQueryString();
        $categories = Categorie::all(); // Pour le formulaire de filtrage

        return view('annonces.dashboard', compact('annonces', 'categories'));
    }

    /**
     * Afficher le formulaire de création d'une nouvelle annonce.
     */
    public function create()
    {
        $categories = Categorie::all();
        return view('annonces.create', compact('categories'));
    }

    /**
     * Stocker une nouvelle annonce dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:perdu,retrouvé',
            'categorie_id' => 'required|exists:categories,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|date',
            'lieu' => 'required|string|max:255',
        ]);

        $annonce = new Annonce($request->all());
        $annonce->user_id = Auth::id();

        if ($request->hasFile('images')) {
            $imagePath = $request->file('images')->store('images', 'public');
            $annonce->images = $imagePath;
        }

        $annonce->save();

        return redirect()->route('annonces.index')->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Afficher le formulaire d'édition d'une annonce.
     */
    public function edit($id)
    {
        $annonce = Annonce::findOrFail($id);

        // Vérifier que l'utilisateur possède l'annonce
        if ($annonce->user_id !== Auth::id()) {
            return redirect()->route('annonces.index')->with('error', 'Vous n’êtes pas autorisé à modifier cette annonce.');
        }

        $categories = Categorie::all();
        return view('annonces.edit', compact('annonce', 'categories'));
    }

    /**
     * Mettre à jour une annonce dans la base de données.
     */
    public function update(Request $request, $id)
    {
        $annonce = Annonce::findOrFail($id);

        // Vérifier que l'utilisateur possède l'annonce
        if ($annonce->user_id !== Auth::id()) {
            return redirect()->route('annonces.index')->with('error', 'Vous n’êtes pas autorisé à modifier cette annonce.');
        }

        $request->validate([
            'type' => 'required|in:perdu,retrouvé',
            'categorie_id' => 'required|exists:categories,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date' => 'required|date',
            'lieu' => 'required|string|max:255',
            'statut' => 'required|in:active,résolue,en attente',
        ]);

        $annonce->fill($request->all());

        if ($request->hasFile('images')) {
            // Supprimer l'ancienne image si existante
            if ($annonce->images) {
                \Storage::disk('public')->delete($annonce->images);
            }

            $imagePath = $request->file('images')->store('images', 'public');
            $annonce->images = $imagePath;
        }

        $annonce->save();

        return redirect()->route('annonces.index')->with('success', 'Annonce mise à jour avec succès.');
    }

    /**
     * Supprimer une annonce de la base de données.
     */
    public function destroy($id)
    {
        $annonce = Annonce::findOrFail($id);

        // Vérifier que l'utilisateur possède l'annonce
        if ($annonce->user_id !== Auth::id()) {
            return redirect()->route('annonces.index')->with('error', 'Vous n’êtes pas autorisé à supprimer cette annonce.');
        }

        // Supprimer l'image si existante
        if ($annonce->images) {
            \Storage::disk('public')->delete($annonce->images);
        }

        $annonce->delete();

        return redirect()->route('annonces.index')->with('success', 'Annonce supprimée avec succès.');
    }
}
