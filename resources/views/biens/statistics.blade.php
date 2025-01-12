@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Statistiques des Biens</h1>

    <table id="statsTable" class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Status</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stats as $stat)
                <tr>  
                    <td>{{ $stat->nom }}</td>
                    <td>{{ $stat->type }}</td>
                    <td>{{ $stat->status }}</td>
                    <td>{{ $stat->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
