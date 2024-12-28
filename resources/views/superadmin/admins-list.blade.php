@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Tableau de bord Super Administrateur</h1>

    <!-- Section des statistiques -->
    <div class="d-flex justify-content-center mb-4">
        <div class="row w-100 justify-content-center">
            <div class="col-md-4">
                <div class="card bg-primary text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Agences</h5>
                        <p class="card-text" id="agencies">0</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white text-center">
                    <div class="card-body">
                        <h5 class="card-title">Administrateurs</h5>
                        <p class="card-text" id="admins">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Section des administrateurs -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Administrateurs</h3>
            <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#createAdminModal">
                <i class="fas fa-plus"></i>Ajouter un administrateur
            </button>
        </div>
        <div class="card-body">
            <table id="adminsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Agence</th>
                        <th>Status</th>
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
                            <span class="badge {{ $admin->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $admin->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>  
                            <!-- Bouton Modifier -->
                            <button type="button"
                            class="btn btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editAdminModal-{{ $admin->id }}"
                                title="Modifier">
                                <i class="fas fa-edit"></i>
                                
                            </button>
                            
                            <form action="#" method="POST" class="d-inline">
                                @csrf
                                <button type="button" 
                                  class="btn btn-sm {{ $admin->is_active }} btn-confirm"
                                  data-url="{{ route('superadmin.toggleUserStatus', $admin->id) }}"
                                  data-action="{{ $admin->is_active ? 'Désactiver' : 'Activer' }}" 
                                  data-bs-toggle="modal" 
                                  data-bs-target="#confirmationModal"
                                  title="{{ $admin->is_active ? 'Désactiver le compte' : 'Activer le compte' }}">
                                  <i class="fas fa-power-off"></i>
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
</div>

<!-- Modals -->
@include('superadmin.create-admin', ['agences' => $agences])

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
   $(document).ready(function () {
    // Récupération des statistiques
    fetch('{{ route("statistics") }}')
    .then(response => {
        console.log("Réponse brute :", response);
        if (!response.ok) {
            throw new Error("Erreur lors de la récupération des statistiques : " + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log("Statistiques reçues :", data);
        document.getElementById("agencies").innerText = data.agencies || 0;
        document.getElementById("admins").innerText = data.admins || 0;
    })
    .catch(error => {
        console.error("Erreur lors de la récupération des statistiques :", error);
        alert("Impossible de charger les statistiques. Veuillez vérifier la connexion réseau ou le serveur.");
    });

    // Gérer les boutons de confirmation
    document.querySelectorAll('.btn-confirm').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Empêche le comportement par défaut du bouton (ne pas soumettre tout de suite)

            // Récupérer les informations du bouton
            const url = button.getAttribute('data-url');
            const action = button.getAttribute('data-action'); // 'Désactiver' ou 'Activer'

            // Modifier le texte dynamique dans le modal
            const modalBody = document.querySelector('#modalActionText');
            modalBody.innerHTML = `Êtes-vous sûr de vouloir ${action} ce compte ?`;

            // Ouvrir le modal
            const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            modal.show();

            // Confirmer l'action
            const confirmButton = document.getElementById('confirmAction');
            confirmButton.onclick = function() {
                // Créer un formulaire pour soumettre la requête
                const form = document.createElement('form');
                form.action = url;
                form.method = 'POST'; // Vous utilisez ici POST pour l'activation/désactivation
                form.innerHTML = `
                    @csrf
                    @method('PATCH')
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
});

</script>
@endpush
