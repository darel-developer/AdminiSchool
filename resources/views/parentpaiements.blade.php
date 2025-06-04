<!-- filepath: c:\xampp\htdocs\Adminischool\resources\views\parentpaiements.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            background: #f3f4f7;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .paiement-card {
            background: #f6f8fc;
            border: 1.5px solid #e3e6ed;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            transition: box-shadow 0.2s, border 0.2s;
        }
        .paiement-card:hover {
            box-shadow: 0 8px 28px rgba(0,0,0,0.13);
            border-color: #b3c0d1;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des Paiements</h1>
        <div class="row g-4">
            @foreach($paiements as $paiement)
                <div class="col-md-6 col-lg-4">
                    <div class="card paiement-card shadow-sm border-0 h-100" style="position: relative;">
                        <div class="card-body pb-2 pt-3" style="position: relative;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold text-primary" style="font-size: 1.1rem;">
                                        {{ $paiement->typepaiement }}
                                    </div>
                                    <div class="text-success" style="font-size: 1.3rem; font-weight: bold;">
                                        {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                                    </div>
                                </div>
                                <a href="{{ route('paiement.download', $paiement->id) }}" class="btn btn-success btn-sm" style="border-radius: 8px;">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-secondary">Facture N° {{ $paiement->num_facture }}</span>
                            </div>
                            <a href="{{ route('paiement.facture', $paiement->id) }}" class="btn btn-outline-primary btn-sm mb-2" target="_blank">
                                Voir la Facture
                            </a>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-end" style="border-radius: 0 0 18px 18px;">
                            <div>
                                <span class="fw-bold">{{ $paiement->nom }} {{ $paiement->prenom }}</span>
                            </div>
                            <div>
                                <span class="badge {{ $paiement->etat == 'Payé' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $paiement->etat }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="javascript:history.back()" class="btn btn-primary mt-4">Retour</a>
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
</body>
</html>