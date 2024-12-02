<!DOCTYPE html>
<html lang="fr">

<head>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Se déconnecter</button>
    </form>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Lien vers le fichier CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des agences</title>

    <!-- Lien vers Bootstrap CSS (Version 5.3.0-alpha1) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- Lien vers FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Centrer le message de succès/erreur */
        .alert-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1050;
            width: 90%;
            max-width: 600px;
        }

        /* Style de l'alerte de succès */
        .alert-success-custom {
            background-color: #28a745; /* Couleur verte */
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
        }

        .alert-success-custom i {
            margin-right: 10px;
        }

        /* Animation pour disparaître après quelques secondes */
        .fade-out {
            animation: fadeOut 10s forwards;
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>

<body>
    <!-- Affichage des messages de succès (Alertes flottantes) -->
    @if(session('success'))
        <div class="alert-container fade-out" id="success-alert">
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Affichage des messages d'erreur (Modale avec détails) -->
    @if(session('error'))
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel"><i class="fas fa-times-circle"></i> Erreur</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <strong>Détails de l'erreur:</strong> <br>
                        {{ session('error') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- <!-- En-tête de page (Header) -->
    <header>
        @include('includes.navbar') <!-- Inclusion de la navbar moderne -->
    </header> --}}

    <!-- Contenu principal -->
    <main class="container mt-4">
        @yield('content')
    </main>

    <!-- Pied de page (Footer) -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; {{ date('Y') }} - Gestion Immobilière</p>
    </footer>

    <!-- Ajoutez jQuery avant votre script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Lien vers Bootstrap JS et jQuery (nécessaire pour certains composants Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour faire disparaître les messages après 10 secondes -->
    <script>
        $(document).ready(function() {
            // Si un message de succès est affiché, le faire disparaître après 10 secondes
            if ($('#success-alert').length) {
                setTimeout(function() {
                    $('#success-alert').fadeOut('slow');
                }, 10000); // 10000 millisecondes = 10 secondes
            }

            // Si un message d'erreur est affiché, l'ouvrir dans une modale
            if ($('#errorModal').length) {
                $('#errorModal').modal('show');
            }
        });
    </script>
</body>
</html>
