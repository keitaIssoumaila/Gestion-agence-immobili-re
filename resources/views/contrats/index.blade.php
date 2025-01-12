@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card w-75">
        <div class="card-header text-center bg-primary text-white">
            {{ strtoupper(Auth::user()->agence->nom) }} - LISTE DES CONTRATS
        </div>
        <div class="card-body">
            <a href="{{ route('contrats.create') }}" class="btn btn-success mb-3">
                <i class="fas fa-plus"></i> Nouveau Contrat
            </a>
            <table id="adminsTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Début</th>
                        <th>Date Fin</th>
                        <th>Montant</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrats as $contrat)
                        <tr>
                            <td>{{ $contrat->id }}</td>
                            <td>{{ $contrat->date_debut }}</td>
                            <td>{{ $contrat->date_fin }}</td>
                            <td>{{ $contrat->montant }}</td>
                            <td>
                                <a href="{{ route('contrats.show', $contrat->id) }}" class="btn btn-sm" title="Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('contrats.edit', $contrat->id) }}" class="btn btn-sm" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('contrats.destroy', $contrat->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <button id="printButton" class="btn btn-sm" title="Imprimer"> 
                                    <i class="fa fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun contrat trouvé</td>
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
