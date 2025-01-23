<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/schoolpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des Paiements</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Type de Paiement</th>
                    <th>Montant</th>
                    <th>Numéro de Facture</th>
                    <th>État</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->nom }}</td>
                        <td>{{ $paiement->prenom }}</td>
                        <td>{{ $paiement->typepaiement }}</td>
                        <td>{{ $paiement->montant }}</td>
                        <td>{{ $paiement->num_facture }}</td>
                        <td>{{ $paiement->etat }}</td>
                        <td>
                            <a href="{{ route('paiement.show', $paiement->id) }}" class="btn btn-primary">Verifier</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>