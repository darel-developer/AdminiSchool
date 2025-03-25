<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\parentpaiements.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Liste des Paiements</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Type de Paiement</th>
                    <th>Montant</th>
                    <th>Numéro de Facture</th>
                    <th>État</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('parentpaiement') }}" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>