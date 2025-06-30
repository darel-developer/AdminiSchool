<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques des Performances des Élèves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7fb;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #22304f 0%, #34495e 100%);
            color: #ecf0f1;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.08);
            z-index: 1050;
            transition: transform 0.3s ease;
        }
        .sidebar-title {
            font-family: 'Lemonada', cursive;
            font-weight: 700;
            font-size: 1.4rem;
            text-align: center;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        .sidebar-separator {
            border-top: 1px solid #34495e;
            margin: 10px 20px;
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
            flex-grow: 1;
            padding: 32px 24px 24px 24px;
            background: #fff;
            min-height: 100vh;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            max-width: 1100px;
            margin: 40px auto 0 auto;
        }
        .btn-primary, .btn-success {
            border-radius: 8px;
            font-weight: 500;
        }
        .table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        .alert {
            border-radius: 8px;
        }
        .card {
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            border: none;
        }
        .card-header {
            font-weight: 600;
            font-size: 1.1rem;
            background: #f4f7fb;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
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
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(44,62,80,0.25);
            z-index: 1049;
        }
        .sidebar.open ~ .sidebar-overlay {
            display: block;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                width: 180px;
                z-index: 1050;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .content {
                margin-left: 0;
                padding: 18px 2vw 18px 2vw;
                margin-top: 24px;
            }
            .sidebar-toggle {
                display: flex;
            }
        }
        @media (max-width: 767.98px) {
            .content {
                padding: 10px 1vw 10px 1vw;
                margin-top: 16px;
            }
            .sidebar {
                width: 140px;
            }
            .table th, .table td {
                font-size: 0.95rem;
                padding: 0.5rem;
            }
        }
        @media (max-width: 575.98px) {
            .sidebar {
                width: 100vw;
                padding: 8px 0;
            }
            .sidebar-title {
                font-size: 1.1rem;
            }
            .sidebar-item {
                font-size: 0.98rem;
                padding: 10px 18px;
            }
            .content {
                padding: 8px 2px 8px 2px;
                margin-top: 8px;
            }
            .table th, .table td {
                font-size: 0.89rem;
                padding: 0.35rem;
            }
        }
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
        <div class="sidebar-separator"></div>
        <!-- ...existing sidebar items... -->
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/dashboard.png') }}" alt="dashboard">
            Dashboard
        </a>
        <a href="{{route('teacherchat')}}" class="sidebar-item">
            <img src="{{ asset('images/chat.png') }}" alt="chat">
            Chat
        </a>
        <a href="{{ route('teacher.statistics') }}" class="sidebar-item">
            <img src="{{ asset('images/statistics.png') }}" alt="statistics">
            Statistiques
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/setting.png') }}" alt="settings">
            Settings
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="content">
        <div class="container mt-5">
            <h1 class="text-center mb-4">Statistiques des Performances des Élèves</h1>

            <!-- Boutons d'action -->
            <div class="mb-4 d-flex justify-content-center gap-3">
                <a href="{{ route('teacher.statistics.pdf') }}" class="btn btn-success" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Télécharger PDF
                </a>
                <a href="{{ route('teacher.schedule') }}" class="btn btn-primary" target="_blank">
                    <i class="bi bi-calendar-week"></i> Historique des cours & Emploi du temps
                </a>
            </div>
    
            <!-- Tableau des statistiques -->
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nom de l'Élève</th>
                            <th>Matière</th>
                            <th>Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statistics as $stat)
                        <tr>
                            <td>{{ $stat->student_name }}</td>
                            <td>{{ $stat->matiere }}</td>
                            <td>{{ number_format($stat->average_grade, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    
            <!-- Graphiques -->
            <div class="mt-5">
                <h3 class="text-center">Distribution des Notes des Élèves</h3>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <canvas id="gradeDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <!-- Inclusion de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Préparation des données pour le graphique
        const statistics = @json($statistics);

        // Récupérer toutes les notes (moyennes) des élèves
        const allGrades = statistics.map(stat => parseFloat(stat.average_grade));

        // Regrouper les notes par tranches (par exemple, 0-2, 2-4, ..., 18-20)
        function getGradeBins(grades, step = 2) {
            const bins = {};
            for (let i = 0; i <= 20; i += step) {
                const label = `${i}-${i+step}`;
                bins[label] = 0;
            }
            grades.forEach(grade => {
                let bin = Math.floor(grade / step) * step;
                if (bin > 18) bin = 18; // dernière tranche 18-20
                const label = `${bin}-${bin+step}`;
                bins[label]++;
            });
            return bins;
        }

        const bins = getGradeBins(allGrades, 2);
        const labels = Object.keys(bins);
        const data = Object.values(bins);

        // Couleur harmonisée
        const mainColor = 'rgba(54, 162, 235, 0.7)';
        const borderColor = 'rgba(54, 162, 235, 1)';

        // Graphique de distribution des notes
        const ctx = document.getElementById('gradeDistributionChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "Nombre d'élèves",
                    data: data,
                    backgroundColor: mainColor,
                    borderColor: borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: "Nombre d'élèves" } },
                    x: { title: { display: true, text: "Tranches de notes" } }
                }
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
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
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        // Close sidebar on navigation (mobile)
        document.querySelectorAll('.sidebar-item').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) closeSidebar();
            });
        });
    </script>
</body>
</html>
