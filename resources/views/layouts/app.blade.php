<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des agences</title>

    <!-- Bootstrap CSS local -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/all.css') }}">


    <!-- DataTables CSS local -->
    <link rel="stylesheet" href="{{ asset('css/dataTable/dataTables.bootstrap5.min.css') }}">

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
            background-color: #28a745;
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

        /* Ajout des styles pour l'impression */
        @media print {
            body * {
                visibility: hidden;
            }
            .card, .card * {
                visibility: visible;
            }
            .card {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    @if(session('success'))
        <div class="alert-container fade-out" id="success-alert">
            <div class="alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        </div>
    @endif

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

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; {{ date('Y') }} - Gestion Immobilière</p>
    </footer>

    <!-- jQuery local -->
    <script src="{{ asset('js/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap JS local -->
    <script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables JS local -->
    <script src="{{ asset('js/dataTable/dataTables.js') }}"></script>
    <script src="{{ asset('js/dataTable/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Script pour DataTables -->
    <script>
        $(document).ready(function() {
            // Initialisation de DataTables
            $('#adminsTable').DataTable({
                language: {
                    url: "{{ asset('js/datatables.french.json') }}" // Assurez-vous de l'avoir localisé si nécessaire
                },
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true
            });

            // Si un message de succès est affiché, le faire disparaître après 10 secondes
            if ($('#success-alert').length) {
                setTimeout(function() {
                    $('#success-alert').fadeOut('slow');
                }, 10000);
            }

            // Si un message d'erreur est affiché, l'ouvrir dans une modale
            if ($('#errorModal').length) {
                $('#errorModal').modal('show');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
