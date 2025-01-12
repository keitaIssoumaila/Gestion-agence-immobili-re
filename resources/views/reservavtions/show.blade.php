@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de la Réservation</h1>

    <div class="card">
        <div class="card-header">
            {{ strtoupper(Auth::user()->agence->nom) }} - RÉSERVATION POUR LE BIEN : {{ $reservation->bien->nom }}
        </div>
        <div class="card-body">
            <p><strong>Locataire :</strong> {{ $reservation->locataire->nom }} {{ $reservation->locataire->prenom }}</p>
            <p><strong>Bien :</strong> {{ $reservation->bien->nom }}</p>
            <p><strong>Date de Réservation :</strong> {{ $reservation->date_reservation }}</p>
            <p><strong>Statut :</strong> {{ ucfirst($reservation->status) }}</p>

            <button id="printReservationButton" class="btn btn-primary" title="Imprimer">
                <i class="fas fa-print"></i> 
            </button>

            <a href="{{ route('reservations.index') }}" class="btn btn-secondary mt-2" title="Retour">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('printReservationButton').addEventListener('click', function () {
        const originalContent = document.body.innerHTML;
        const printContent = document.querySelector('.card').outerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Recharge la page après impression
    });
</script>
@endpush
@endsection
