@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-75">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - LISTE DES RÉSERVATIONS
        </div>
        <div class="card-body">
            <a href="{{ route('reservations.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Ajouter une Réservation
            </a>
            <table id="reservationsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Locataire</th>
                        <th>Bien</th>
                        <th>Date de Réservation</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ $reservation->locataire->nom }} {{ $reservation->locataire->prenom }}</td>
                            <td>{{ $reservation->bien->nom }}</td>
                            <td>{{ $reservation->date_reservation }}</td>
                            <td>{{ ucfirst($reservation->status) }}</td>
                            <td>
                                <a href="{{ route('reservations.show', $reservation->id) }}" class="btn btn-sm" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <button id="printButton{{ $reservation->id }}" class="btn btn-sm" title="Imprimer">
                                    <i class="fa fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune réservation trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('printButton').addEventListener('click', function () {
        const originalContent = document.body.innerHTML;
        const printContent = document.querySelector('table').outerHTML; // Cibler la table entière

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload(); // Recharge la page après impression
    });
</script>
@endpush