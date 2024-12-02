@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tableau de bord Super Administrateur</h1>

    <!-- Section des statistiques -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Agences</h5>
                    <p class="card-text" id="stat-agencies">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Utilisateurs</h5>
                    <p class="card-text" id="stat-users">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white text-center">
                <div class="card-body">
                    <h5 class="card-title">Administrateurs</h5>
                    <p class="card-text" id="stat-admins">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des administrateurs -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Administrateurs</h3>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createAdminModal">Ajouter un administrateur</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Agence</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->agence->nom }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAdminModal-{{ $admin->id }}">Modifier</button>
                            <form action="{{ route('toggle-user-status', $admin->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $admin->is_active ? 'btn-danger' : 'btn-success' }}">
                                    {{ $admin->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @include('superadmin.edit-admin', ['admin' => $admin, 'agences' => $agences])
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section des utilisateurs -->
    <div class="card">
        <div class="card-header">
            <h3>Utilisateurs</h3>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createUserModal">Ajouter un utilisateur</button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal-{{ $user->id }}">Modifier</button>
                            <form action="{{ route('toggle-user-status', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                                    {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @include('superadmin.edit-user', ['user' => $user]) <!-- Modal de modification de l'utilisateur -->
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals -->
@include('superadmin.create-admin', ['agences' => $agences])
@include('superadmin.create-user')

<!-- Modal de confirmation pour l'activation/désactivation -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmer l'activation/désactivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir activer/désactiver cet utilisateur ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAction">Confirmer</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('{{ route("statistics") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById("stat-agencies").innerText = data.agencies;
                document.getElementById("stat-users").innerText = data.users;
                document.getElementById("stat-admins").innerText = data.admins;
            });

        // Configuration du modal de confirmation
        document.querySelectorAll('.btn-confirm').forEach(function(button) {
            button.addEventListener('click', function(event) {
                var url = event.target.getAttribute('data-url');
                document.getElementById('confirmAction').onclick = function() {
                    window.location.href = url;
                };
            });
        });
    });
</script>
@endsection
