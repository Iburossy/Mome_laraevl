@extends('layouts.app')

@section('title', 'Modifier la Catégorie')

@section('content')
    <h1>Modifier la Catégorie</h1>

    <form action="{{ route('categories.update', $categorie->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la Catégorie</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $categorie->nom) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Mettre à Jour</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
