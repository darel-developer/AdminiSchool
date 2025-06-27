<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #22304f 0%, #34495e 100%);
            color: #ecf0f1;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
            z-index: 1050;
            transition: transform 0.3s ease;
        }
        .sidebar-title {
            font-family: 'Lemonada', cursive;
            font-weight: 700;
            font-size: 1.7rem;
            text-align: center;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 28px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            border-radius: 8px;
            margin: 4px 12px;
            transition: background 0.2s, color 0.2s;
            font-size: 1.07rem;
        }
        .sidebar-item:hover, .sidebar-item.active {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .sidebar-item img {
            width: 26px;
            height: 26px;
            margin-right: 14px;
        }
        .content {
            margin-left: 250px;
            padding: 32px 24px 24px 24px;
            flex-grow: 1;
            min-height: 100vh;
            background: #f4f7fb;
            transition: margin-left 0.3s;
        }
        .dashboard-card {
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            border: none;
            background: #fff;
            transition: transform 0.18s, box-shadow 0.18s;
        }
        .dashboard-card:hover {
            transform: translateY(-4px) scale(1.03);
            box-shadow: 0 8px 24px rgba(44, 62, 80, 0.13);
        }
        .dashboard-title {
            font-size: 1.18rem;
            font-weight: 600;
            color: #22304f;
            margin-bottom: 6px;
        }
        .dashboard-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #007bff;
        }
        .card h5 {
            font-weight: 600;
            color: #22304f;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .modal-content {
            border-radius: 14px;
        }
        /* Hamburger menu */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 18px;
            left: 18px;
            z-index: 1100;
            background: #22304f;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 2px 8px rgba(44,62,80,0.13);
        }
        /* Responsive styles */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: 220px;
                z-index: 1050;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                padding: 18px 2vw 18px 2vw;
            }
            .sidebar-toggle {
                display: flex;
            }
        }
        @media (max-width: 767.98px) {
            .dashboard-card {
                margin-bottom: 18px;
            }
            .content {
                padding: 10px 1vw 10px 1vw;
            }
            .row {
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .col-md-3, .col-md-6, .col-md-12, .col-12 {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            .dashboard-title {
                font-size: 1rem;
            }
            .dashboard-value {
                font-size: 1.3rem;
            }
            .sidebar {
                width: 180px;
            }
        }
        @media (max-width: 575.98px) {
            .sidebar {
                width: 100vw;
                padding: 14px 0;
            }
            .sidebar-title {
                font-size: 1.2rem;
            }
            .sidebar-item {
                font-size: 0.98rem;
                padding: 10px 18px;
            }
            .dashboard-card {
                padding: 10px 4px !important;
            }
            .modal-content {
                padding: 0 2vw;
            }
        }
        /* Ajout pour forcer les cartes à passer en colonne sur mobile */
        @media (max-width: 991.98px) {
            .row.g-3 > [class^="col-"], .row.g-3 > [class*=" col-"] {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        /* Empêche le scroll horizontal */
        html, body {
            max-width: 100vw;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <!-- Hamburger menu button -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Menu">
        <i class="fas fa-bars"></i>
    </button>
    <div class="sidebar" id="sidebarMenu">
        <div class="sidebar-title">ADMINISCHOOL</div>
        <a href="#" class="sidebar-item active">
            <img src="{{ asset('images/Statistics.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('school')}}" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Données
        </a>
        <a href="{{ route('documentschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Add_Document.png') }}" alt="document">
            Documents
        </a>
        <a href="{{ route('eventschool') }}" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="event">
            Evenements
        </a>
        <a href="{{ route('schoolpaiement') }}" class="sidebar-item">
            <img src="{{ asset('images/paiement.png') }}" alt="payment">
            Paiements
        </a>
        <a href="{{route('userschool')}}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="user">
            Utilisateur
        </a>
        <a href="{{route('studentschool')}}" class="sidebar-item">
            <img src="{{ asset('images/action.png') }}" alt="user">
            Etudiant
        </a>
        <a href="{{ route('create.teacher') }}" class="sidebar-item">
            <img src="{{ asset('images/teacher.png') }}" alt="teacher">
            Créer enseignant
        </a>
        <a href="{{ route('cahiertexte') }}" class="sidebar-item">
            <img src="{{ asset('images/Book.png') }}" alt="teacher">
           cahier de texte
        </a>
        <a href="{{ route('helpsupport') }}" class="sidebar-item">
            <img src="{{ asset('images/chatbot.png') }}" alt="help support">
            Help Support
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="content">
        <div class="container-fluid mt-3 mt-md-5">
            <h1 class="text-center mb-4" style="font-weight:700;letter-spacing:1px;">Dashboard</h1>
            <div class="row g-3">
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('students.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Etudiants <i class="fas fa-user-graduate"></i></div>
                            <div class="dashboard-value">{{ $studentCount }}</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('convocations.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Convocations <i class="fas fa-bullhorn"></i></div>
                            <div class="dashboard-value">{{ $convocationCount }}</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <a href="{{ route('absences.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Absences <i class="fas fa-calendar-times"></i></div>
                            <div class="dashboard-value">{{ $absenceCount }}</div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                     <a href="{{ route('paiements.details') }}" class="text-decoration-none">
                        <div class="card dashboard-card p-3 text-center">
                            <div class="dashboard-title">Paiements <i class="fas fa-money-bill-wave"></i></div>
                            <div class="dashboard-value">{{ $paiementCount }}</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row mt-4 g-3">
                <div class="col-12 col-md-6">
                    <div class="card p-3 h-100">
                        <h5>Activités récentes</h5>
                        <ul class="mb-0 ps-3">
                            <li>Nouveau étudaint inscrit</li>
                            <li>Etudiant Devas nya ajouté au système</li>
                            <li>Evenement Créer</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card p-3 h-100">
                        <h5>Notifications</h5>
                        <ul class="mb-0 ps-3">
                            <li>Paiement de 5 étudiants</li>
                            <li>3 absences reported today</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row mt-4 g-3">
                <div class="col-12">
                    <div class="card p-3">
                        <h5>Actions Rapides</h5>
                        <div class="d-flex flex-wrap gap-2 justify-content-around">
                            <a href="{{ route('reports.absences') }}" class="btn btn-primary flex-grow-1 flex-md-grow-0">Rapport des Absences</a>
                            <a href="{{ route('reports.convocations') }}" class="btn btn-warning flex-grow-1 flex-md-grow-0">Rapport des Convocations</a>
                            <a href="{{ route('reports.paiements') }}" class="btn btn-success flex-grow-1 flex-md-grow-0">Rapport des Paiements</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 g-3">
                <div class="col-12 col-md-6">
                    <div class="card p-4 h-100">
                        <h5 class="text-center">Comparaison type de paiement</h5>
                        <canvas id="paymentChart" width="200" height="200"></canvas>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card p-4 h-100">
                        <h5 class="text-center">Convocations par mois</h5>
                        <canvas id="registrationChart" width="200" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- Section pour afficher le graphe personnalisé -->
            <div class="row mt-4" id="customChartSection" style="display:none;">
                <div class="col-12">
                    <div class="card p-4">
                        <h5 class="text-center">Graphe personnalisé</h5>
                        <canvas id="customChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <!-- Bouton pour ouvrir la modale -->
            <div class="d-flex justify-content-end mt-4">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#customChartModal">
                    <i class="fas fa-chart-bar"></i> Créer un graphe personnalisé
                </button>
            </div>
        </div>
    </div>

    <!-- Modale pour la création du graphe personnalisé -->
    <div class="modal fade" id="customChartModal" tabindex="-1" aria-labelledby="customChartModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="customChartModalLabel">Créer un graphe personnalisé</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            <form id="customChartForm">
                <div class="mb-3">
                    <label for="chartType" class="form-label">Type de graphe</label>
                    <select class="form-select" id="chartType" required>
                        <option value="bar">Histogramme</option>
                        <option value="pie">Camembert</option>
                        <option value="line">Courbe</option>
                        <option value="doughnut">Doughnut</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Données à utiliser</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dataStudents" value="students">
                        <label class="form-check-label" for="dataStudents">Elèves</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dataPaiements" value="paiements">
                        <label class="form-check-label" for="dataPaiements">Paiements</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="dataAbsences" value="absences">
                        <label class="form-check-label" for="dataAbsences">Absences</label>
                    </div>
                    <!-- Ajouter d'autres données si besoin -->
                </div>
                <div class="mb-3">
                    <label class="form-label">Critères d'affichage</label>
                    <select class="form-select" id="displayCriteria">
                        <option value="sum">Somme</option>
                        <option value="count">Nombre</option>
                        <option value="top5">Top 5</option>
                        <!-- Ajouter d'autres critères si besoin -->
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Générer le graphe</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('paymentChart').getContext('2d');
        const paymentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pension', 'Autre'],
                datasets: [{
                    label: 'Payment Types',
                    data: [{{ $pensionCount }}, {{ $otherCount }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        const registrationCtx = document.getElementById('registrationChart').getContext('2d');
        const registrationChart = new Chart(registrationCtx, {
            type: 'bar',
            data: {
                labels: ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
                datasets: [{
                    label: 'Convocations envoyées',
                    data: [{{ implode(',', $monthlyConvocations) }}], 
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                }
            }
        });

        // --- Graphe personnalisé via AJAX ---
        let customChartInstance = null;

        document.getElementById('customChartForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const chartType = document.getElementById('chartType').value;
            const criteria = document.getElementById('displayCriteria').value;
            const types = [];
            if (document.getElementById('dataStudents').checked) types.push('students');
            if (document.getElementById('dataPaiements').checked) types.push('paiements');
            if (document.getElementById('dataAbsences').checked) types.push('absences');

            // Correction ici : envoyer types au lieu de selectedData
            fetch("{{ route('dashboard.customChartData') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    chartType: chartType,
                    criteria: criteria,
                    types: types
                })
            })
            .then(response => response.json())
            .then(result => {
                // Afficher la section du graphe personnalisé
                document.getElementById('customChartSection').style.display = 'block';

                // Détruire l'ancien graphe si existant
                if (customChartInstance) {
                    customChartInstance.destroy();
                }

                // Créer le nouveau graphe avec les données reçues
                const ctx = document.getElementById('customChart').getContext('2d');
                customChartInstance = new Chart(ctx, {
                    type: chartType,
                    data: {
                        labels: result.labels,
                        datasets: result.datasets.map((ds, idx) => ({
                            ...ds,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.5)',
                                'rgba(255, 206, 86, 0.5)',
                                'rgba(255, 99, 132, 0.5)',
                                'rgba(75, 192, 192, 0.5)',
                                'rgba(153, 102, 255, 0.5)'
                            ][idx % 5],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)'
                            ][idx % 5],
                            borderWidth: 1
                        }))
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            }
                        }
                    }
                });

                // Fermer la modale
                var modal = bootstrap.Modal.getInstance(document.getElementById('customChartModal'));
                modal.hide();
            });
        });

        // Sidebar toggle for mobile/tablet
        const sidebar = document.getElementById('sidebarMenu');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.style.display = 'none';
        }
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.style.display = 'block';
        }
        sidebarToggle.addEventListener('click', function() {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
        sidebarOverlay.addEventListener('click', closeSidebar);
        // Close sidebar on navigation (mobile)
        document.querySelectorAll('.sidebar-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) closeSidebar();
            });
        });

        // Bouton pour supprimer le graphe personnalisé
        document.addEventListener('DOMContentLoaded', function() {
            const section = document.getElementById('customChartSection');
            if (section) {
                const btn = document.createElement('button');
                btn.className = 'btn btn-danger mt-2';
                btn.innerHTML = '<i class="fas fa-trash"></i> Supprimer le graphe';
                btn.onclick = function() {
                    if (customChartInstance) {
                        customChartInstance.destroy();
                        customChartInstance = null;
                    }
                    section.style.display = 'none';
                };
                section.querySelector('.card').appendChild(btn);
            }
        });
    </script>
</body>
</html>