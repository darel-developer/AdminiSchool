@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Details des Paiements</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Type de Paiement</th>
                <th>Montant</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paiements as $paiement)
            <tr>
                <td>{{ $paiement->id }}</td>
                <td>{{ $paiement->nom }}</td>
                <td>{{ $paiement->prenom }}</td>
                <td>{{ $paiement->typepaiement }}</td>
                <td>{{ $paiement->montant }}</td>
                <td>{{ $paiement->etat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection