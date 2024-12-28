@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Liste des Agences</h1>

    <!-- Tableau des agences -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Agence</h3>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="fas fa-plus"></i>Ajouter une Agence
            </button>
        </div>
        <div class="card-body">
            <table id="adminsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agences as $agence)
                    <tr>
                        <td>{{ $agence->nom }}</td>
                        <td>{{ $agence->adresse }}</td>
                        <td>{{ $agence->email }}</td>
                        <td>{{ $agence->telephone }}</td>
                        <td>
                            <!-- Afficher le statut de l'agence -->
                            <span class="badge {{ $agence->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $agence->is_active ? 'Active' : 'Désactivée' }}
                            </span>
                        </td>
                        <td>
                            <!-- Actions -->
                            <!-- Bouton Modifier -->
                            <button class="btn btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editModal{{ $agence->id }}" 
                                title="Modifier">
                                <i class="fas fa-edit"></i> 
                            </button>

                            <!-- Bouton Supprimer -->
                            <button class="btn btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#deleteModal{{ $agence->id }}" 
                                title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>

                            <!-- Bouton Activer/Désactiver -->
                            <button type="button" 
                                    class="btn btn-sm {{ $agence->is_active ? 'btn-success' : 'btn-danger' }} btn-confirm"
                                    data-url="{{ route('agences.toggle-status', $agence->id) }}"
                                    data-action="{{ $agence->is_active ? 'Désactiver' : 'Activer' }}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmationModal"
                                    title="{{ $agence->is_active ? 'Désactiver l\'agence' : 'Activer l\'agence' }}">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modals pour la création et l'édition -->
@include('agences.create') <!-- Modal de création -->
@foreach ($agences as $agence)
    @include('agences.edit', ['agence' => $agence]) <!-- Modal d'édition -->
    @include('agences.delete', ['agence' => $agence]) <!-- Modal de suppression -->
@endforeach

<!-- Modal pour confirmation d'action -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmer l'action</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Texte dynamique -->
                <p id="modalActionText">Êtes-vous sûr de vouloir effectuer cette action ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="confirmAction">Confirmer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-confirm').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du bouton (ne pas soumettre tout de suite)

            // Récupérer les informations du bouton
            const url = button.getAttribute('data-url');
            const action = button.getAttribute('data-action'); // 'Activer' ou 'Désactiver'

            // Modifier le texte dynamique dans le modal
            const modalBody = document.querySelector('#modalActionText');
            modalBody.innerHTML = `Êtes-vous sûr de vouloir ${action} cette agence ?`;

            // Ouvrir le modal
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();

            // Confirmer l'action
            const confirmButton = document.getElementById('confirmAction');
            confirmButton.onclick = function() {
                // Créer un formulaire pour soumettre la requête
                const form = document.createElement('form');
                form.action = url; // L'URL de la requête
                form.method = 'POST'; // Vous utilisez ici POST pour l'activation/désactivation
                form.innerHTML = `
                    @csrf
                    @method('PATCH') <!-- Cette ligne simule une requête PATCH -->
                `;
                document.body.appendChild(form);
                form.submit(); // Soumettre le formulaire
            };
        });
    });

    // Fermeture du modal (même lorsque l'utilisateur clique sur Annuler ou la croix)
    const modalElement = document.getElementById('confirmationModal');
    const modal = new bootstrap.Modal(modalElement);

    // Supprimer l'effet flou lorsque le modal est fermé (via croix ou annuler)
    const modalCloseButton = document.querySelectorAll('[data-bs-dismiss="modal"], .btn-close');

    modalCloseButton.forEach(button => {
        button.addEventListener('click', function () {
            modal.hide(); // Fermer le modal

            // Supprimer les éléments de fond (backdrop) et la classe modal-open
            document.body.classList.remove('modal-open'); // Supprimer la classe modal-open
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove(); // Supprimer l'arrière-plan flou
            }
        });
    });
</script>

@endpush
