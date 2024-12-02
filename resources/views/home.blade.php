@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="mb-4 text-center">Bienvenue dans le système de gestion des agences immobilières</h1>

            <!-- Section des statistiques principales -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Nombre d'agences</h5>
                            <p class="card-text display-4">{{ $agenciesCount ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Biens disponibles</h5>
                            <p class="card-text display-4">{{ $biensCount ?? '0' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Clients actifs</h5>
                            <p class="card-text display-4">{{ $clientsCount ?? '0' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section des actions rapides -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            Actions rapides
                        </div>
                        {{-- <div class="card-body">
                            <a href="{{ route('agences.index') }}" class="btn btn-primary btn-block mb-2">Gérer les agences</a>
                            <a href="{{ route('biens.index') }}" class="btn btn-success btn-block mb-2">Voir les biens immobiliers</a>
                            <a href="{{ route('clients.index') }}" class="btn btn-warning btn-block mb-2">Gérer les clients</a>
                        </div> --}}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            Notifications
                        </div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @else
                                <p class="text-muted">Aucune notification pour le moment.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section des informations générales -->
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Informations générales
                </div>
                <div class="card-body">
                    <p class="mb-2">Bienvenue, {{ Auth::user()->name }} !</p>
                    <p>Vous êtes connecté en tant que <strong>{{ Auth::user()->role }}</strong>.</p>
                    <p>Dernière connexion : {{ Auth::user()->last_login_at ?? 'Non disponible' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
