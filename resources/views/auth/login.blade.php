@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center">CONNEXION</h2>

    <!-- Affichage du message de statut s'il y en a -->
    @if (session('status'))
        <div class="alert alert-info">
            {{ session('status') }}
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <!-- Champ pour l'email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Champ pour le mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Checkbox pour se souvenir de la connexion -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Se souvenir de moi</label>
                </div>
                
                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-primary w-100">Connexion</button>
                
                <!-- Lien vers la page de réinitialisation de mot de passe -->
                <div class="mt-3 text-center">
                    <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
