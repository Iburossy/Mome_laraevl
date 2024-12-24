@extends('layouts.app')

@section('title', 'Mes Annonces')

@section('content')
    <h1>Mes Annonces</h1>

    <a href="{{ route('annonces.create') }}" class="btn btn-primary mb-3">Déclarer un nouvel objet</a>

    @if($annonces->count())
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Type</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Lieu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($annonces as $annonce)
                    <tr>
                        <td>{{ $annonce->titre }}</td>
                        <td>{{ ucfirst($annonce->type) }}</td>
                        <td>{{ $annonce->categorie->nom }}</td>
                        <td>{{ ucfirst($annonce->statut) }}</td>
                        <td>{{ gettype($annonce->date) }}</td>  <!--le probleme au niveau de cette ligne -->
                        <td>{{ $annonce->lieu }}</td>
                        <td>
                            <a href="{{ route('annonces.showPublic', $annonce->id) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('annonces.edit', $annonce->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('annonces.destroy', $annonce->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $annonces->links() }}
    @else
        <p>Vous n'avez aucune annonce pour le moment.</p>
    @endif
@endsection
