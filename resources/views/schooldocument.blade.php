<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des données des élèves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .sidebar {
            width: 220px;
            display: flex;
            flex-direction: column;
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
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 12px 28px;
            margin: 4px 12px;
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            border-radius: 8px;
            font-size: 1.07rem;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar-item:hover, .sidebar-item.active {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .sidebar-item img {
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }
        .content {
            margin-left: 220px;
            padding: 32px 24px 24px 24px;
            flex-grow: 1;
            min-height: 100vh;
            background: #f4f7fb;
            transition: margin-left 0.3s;
        }
        .form-section {
            display: none;
            opacity: 0;
            transition: opacity 0.5s;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(44, 62, 80, 0.07);
            padding: 24px 18px;
            margin-bottom: 18px;
        }
        .form-section.active {
            display: block;
            opacity: 1;
        }
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 10px;
        }
        .btn-primary, .btn-secondary {
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
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
        /* Overlay for sidebar on mobile */
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
        /* Responsive styles */
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
            }
            .sidebar-toggle {
                display: flex;
            }
        }
        @media (max-width: 767.98px) {
            .content {
                padding: 10px 1vw 10px 1vw;
            }
            .form-section {
                padding: 14px 4px;
            }
            .sidebar {
                width: 140px;
            }
        }
        @media (max-width: 575.98px) {
            .sidebar {
                width: 100vw;
                padding: 14px 0;
            }
            .sidebar-item {
                font-size: 0.98rem;
                padding: 10px 18px;
            }
            .form-section {
                padding: 10px 2px;
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
        <a href="#" class="sidebar-item active">
            <img src="{{ asset('images/Statistics.png') }}" alt="absences">
            Absences
        </a>
        <a href="#" class="sidebar-item">
            <img src="{{ asset('images/Event.png') }}" alt="convocations">
            Convocations
        </a>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="content">
        <div class="container-fluid mt-4">
            <h1 id="main-title" class="text-center mb-4" style="font-weight:700;letter-spacing:1px;">Téléversement des données des élèves</h1>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div id="form-classes" class="form-section active">
                        <form id="uploadFormClasses" method="POST" action="{{ route('classes.upload') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="classFile" class="form-label">Sélectionnez un fichier (Excel, TXT, CSV) classe</label>
                                <input type="file" name="classFile" id="classFile" class="form-control" accept=".xlsx, .xls, .csv, .txt" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Téléverser</button>
                        </form>
                    </div>
                    <div class="navigation-buttons">
                        <button id="prevButton" class="btn btn-secondary">&larr; Précédent</button>
                        <button id="nextButton" class="btn btn-secondary">Suivant &rarr;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('.form-section');
            let currentSectionIndex = 0;

            function showSection(index) {
                sections.forEach((section, i) => {
                    section.classList.toggle('active', i === index);
                });
            }

            document.getElementById('prevButton').addEventListener('click', function () {
                if (currentSectionIndex > 0) {
                    currentSectionIndex--;
                    showSection(currentSectionIndex);
                }
            });

            document.getElementById('nextButton').addEventListener('click', function () {
                if (currentSectionIndex < sections.length - 1) {
                    currentSectionIndex++;
                    showSection(currentSectionIndex);
                }
            });

            showSection(currentSectionIndex);
        });
    </script>
</body>
</html>