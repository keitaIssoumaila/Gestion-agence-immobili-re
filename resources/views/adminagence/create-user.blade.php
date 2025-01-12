@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-uppercase">Liste des utilisateurs de l'agence</h2>
        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createUserModal" title="Créer un nouvel utilisateur">
            <i class="fas fa-user-plus me-2"></i> Créer un utilisateur
        </button>
    </div>

    <table id="adminsTable" class="table table-bordered table-hover">
        <thead >
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
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-danger' }}">
                        {{ $user->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-2">
                        <!-- Modifier -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </button>
                        <!-- Activer/Désactiver -->
                        <button class="btn {{ $user->is_active ? 'btn-success' : 'btn-danger' }} btn-sm" data-bs-toggle="modal" data-bs-target="#toggleStatusModal-{{ $user->id }}" title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                            <i class="fas {{ $user->is_active ? 'fa-user-check' : 'fa-user-slash' }}"></i>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Modal: Modifier l'utilisateur -->
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
                                <!-- Formulaire de modification -->
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
                                    <select name="role" id="role-{{ $user->id }}" class="form-select" required>
                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                        <option value="manager" {{ $user->role === 'manager' ? 'selected' : '' }}>Manager</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                    <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Annuler</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal: Activer/Désactiver -->
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

<!-- Modal: Créer un utilisateur -->
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
                    <!-- Formulaire -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="user">Utilisateur</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Créer</button>
                        <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
