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
                <h3 class="text-center">Graphiques des Performances</h3>
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="averageGradeChart"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="subjectPerformanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

    <!-- Inclusion de Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Préparation des données pour les graphiques
        const statistics = @json($statistics);

        // Pour le graphique barres : chaque élève avec sa moyenne
        const studentNames = statistics.map(stat => stat.student_name);
        const averageGrades = statistics.map(stat => stat.average_grade);

        // Pour le graphique circulaire : matières uniques et moyenne par matière
        const subjectMap = {};
        statistics.forEach(stat => {
            if (!subjectMap[stat.matiere]) {
                subjectMap[stat.matiere] = { total: 0, count: 0 };
            }
            subjectMap[stat.matiere].total += parseFloat(stat.average_grade);
            subjectMap[stat.matiere].count += 1;
        });
        const uniqueSubjects = Object.keys(subjectMap);
        const subjectAverages = uniqueSubjects.map(subject => 
            (subjectMap[subject].total / subjectMap[subject].count).toFixed(2)
        );

        // Graphique des moyennes par élève
        const ctx1 = document.getElementById('averageGradeChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: studentNames,
                datasets: [{
                    label: 'Moyenne des Notes',
                    data: averageGrades,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
                    y: { beginAtZero: true }
                }
            }
        });

        // Graphique des performances par matière (matières uniques)
        const ctx2 = document.getElementById('subjectPerformanceChart').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: uniqueSubjects,
                datasets: [{
                    label: 'Performances par Matière',
                    data: subjectAverages,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    tooltip: { enabled: true }
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
