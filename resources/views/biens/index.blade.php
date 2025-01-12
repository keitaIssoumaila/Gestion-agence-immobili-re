@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des Biens</h1>
    <a href="{{ route('biens.create') }}" class="btn btn-primary mb-3">Ajouter un Bien</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table id="adminsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Adresse</th>
                <th>Surface</th>
                <th>Prix</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($biens as $bien)
                <tr>
                    <td>{{ $bien->nom }}</td>
                    <td>{{ $bien->type }}</td>
                    <td>{{ $bien->adresse }}</td>
                    <td>{{ $bien->surface }}</td>
                    <td>{{ $bien->prix }}</td>
                    <td>{{ $bien->status }}</td>
                    <td>
                        <!-- Bouton Voir -->
                        <a href="{{ route('biens.show', $bien->id) }}" class="btn btn-sm" title="Details">
                            <i class="fas fa-eye"></i>
                        </a>
                    
                        <!-- Bouton Modifier -->
                        <a href="{{ route('biens.edit', $bien->id) }}" class="btn btn-sm" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                    
                        <!-- Bouton Supprimer -->
                        <form action="{{ route('biens.destroy', $bien->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" onclick="return confirm('Êtes-vous sûr de Supprimer ?')" title="Supprimer">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        
                        <!-- Bouton Statistique -->
                        <a href="{{ route('biens.statistics') }}" class="btn btn-sm" title="Statistiques">
                            <i class="fas fa-chart-bar"></i>
                        </a>

                        <!-- Bouton Imprimer -->
                        <button id="printButton" class="btn btn-sm" title="Imprimer"> 
                            <i class="fa fa-print"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
