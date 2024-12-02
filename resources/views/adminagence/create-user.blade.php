@extends('layouts.app')

@section('content')
<div class="container">
    <h2>LISTE DES UTILISATEURS DE L'AGENCE</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Bouton pour ouvrir le modal de création -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Créer un utilisateur
        </button>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <!-- Affichage du statut -->
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
                <td>
                    <!-- Bouton pour modifier -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">
                        Modifier
                    </button>
                    <!-- Bouton pour activer/désactiver -->
                    <button class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }} btn-sm" data-bs-toggle="modal" data-bs-target="#toggleStatusModal-{{ $user->id }}">
                        {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                    </button>
                </td>
            </tr>

            <!-- Modal Bootstrap pour éditer l'utilisateur -->
            <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Modifier l'utilisateur</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div> 
                        <div class="modal-body">
                            <form action="{{ route('adminagence.update-user', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT') 
                                <div class="mb-3">
                                    <label for="name-{{ $user->id }}" class="form-label">Nom</label>
                                    <input type="text" name="name" id="name-{{ $user->id }}" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email-{{ $user->id }}" class="form-label">Email</label>
                                    <input type="email" name="email" id="email-{{ $user->id }}" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="role-{{ $user->id }}" class="form-label">Rôle</label>
                                    <select name="role" id="role-{{ $user->id }}" class="form-control" required>
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                        <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal pour confirmation d'activation/désactivation -->
            <div class="modal fade" id="toggleStatusModal-{{ $user->id }}" tabindex="-1" aria-labelledby="toggleStatusModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="toggleStatusModalLabel">
                                {{ $user->is_active ? 'Désactiver le compte' : 'Activer le compte' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Êtes-vous sûr de vouloir {{ $user->is_active ? 'désactiver' : 'activer' }} ce compte ?</p>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('adminagence.toggleUserStatus', $user->id) }}" method="GET">
                                @csrf
                                <button type="submit" class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                                    Oui, {{ $user->is_active ? 'désactiver' : 'activer' }}
                                </button>
                            </form>
                            
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal pour créer un utilisateur -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Créer un utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('adminagence.store-user') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="user">Utilisateur</option>
                            <option value="manager">Manager</option>
                        </select>
                        @error('role')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection



