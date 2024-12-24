<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceController extends Controller
{
    /**
     * Afficher la liste des annonces publiques.
     */
    public function indexPublic()
    {
        $annonces = Annonce::where('statut', 'active')->paginate(10);
        return view('annonces.index', compact('annonces'));
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
     * Afficher la liste des annonces pour l'utilisateur connecté.
     */
    public function index()
    {
        $annonces = Annonce::where('user_id', Auth::id())->paginate(10);
        return view('annonces.dashboard', compact('annonces'));
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
            return redirect()->route('annonces.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
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
            return redirect()->route('annonces.index')->with('error', 'Vous n\'êtes pas autorisé à modifier cette annonce.');
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
            return redirect()->route('annonces.index')->with('error', 'Vous n\'êtes pas autorisé à supprimer cette annonce.');
        }

        // Supprimer l'image si existante
        if ($annonce->images) {
            \Storage::disk('public')->delete($annonce->images);
        }

        $annonce->delete();

        return redirect()->route('annonces.index')->with('success', 'Annonce supprimée avec succès.');
    }
}
