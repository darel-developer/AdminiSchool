<!-- filepath: /c:/xampp/htdocs/Adminischool/resources/views/showpaiement.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour le paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Mettre à jour le paiement</h1>
        <form method="POST" action="{{ route('paiement.update', $paiement->id) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="etat" class="form-label">État</label>
                <select class="form-control" id="etat" name="etat" required>
                    <option value="en attente" {{ $paiement->etat == 'en attente' ? 'selected' : '' }}>En attente</option>
                    <option value="payé" {{ $paiement->etat == 'payé' ? 'selected' : '' }}>Payé</option>
                    <option value="annulé" {{ $paiement->etat == 'annulé' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
</body>
</html>