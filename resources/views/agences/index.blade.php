@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Agences</h1>

    <!-- Boutons pour créer une nouvelle agence -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus"></i> Ajouter une agence</button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agences as $agence)
            <tr>
                <td>{{ $agence->nom }}</td>
                <td>{{ $agence->adresse }}</td>
                <td>{{ $agence->email }}</td>
                <td>
                    <!-- Boutons d'action -->
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $agence->id }}"><i class="fas fa-edit"></i> Modifier</button>
                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $agence->id }}"><i class="fas fa-trash-alt"></i> Supprimer</button>
                </td>
            </tr>

            <!-- Modal de modification -->
            <div class="modal fade" id="editModal{{ $agence->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $agence->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $agence->id }}">Modifier l'agence : {{ $agence->nom }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('agences.update', $agence->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nom">Nom</label>
                                    <input type="text" name="nom" class="form-control" value="{{ $agence->nom }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" name="adresse" class="form-control" value="{{ $agence->adresse }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $agence->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="telephone">Téléphone</label>
                                    <input type="text" name="telephone" class="form-control" value="{{ $agence->telephone }}">
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="logo" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal de confirmation de suppression -->
            <div class="modal fade" id="deleteModal{{ $agence->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Êtes-vous sûr de vouloir supprimer cette agence ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <form action="{{ route('agences.destroy', $agence->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de création -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Créer une nouvelle agence</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('agences.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" name="adresse" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Téléphone</label>
                        <input type="text" name="telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
