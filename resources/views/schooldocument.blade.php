<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléversement des données des élèves</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
        }
        .sidebar {
            width: 250px;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #ee7724, #d8363a, #dd3675, #b44593);
            border-right: 1px solid #ddd;
            color: #fff;
            padding: 20px 0;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            margin: 5px 0;
            text-decoration: none;
            color: #fff;
        }
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }
        .form-section {
            display: none;
        }
        .form-section.active {
            display: block;
        }
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        /* Styles pour les petits écrans */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: 60px;
                flex-direction: row;
                justify-content: space-around;
                padding: 0;
                border-right: none;
                border-top: 1px solid #ddd;
                position: fixed;
                bottom: 0;
                left: 0;
            }
            .sidebar-item {
                flex-direction: column;
                align-items: center;
                padding: 5px;
                font-size: 12px;
            }
            .sidebar-item img {
                margin-right: 0;
                margin-bottom: 5px;
            }
            .content {
                margin: 0;
                padding-bottom: 80px; 
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="#" class="sidebar-item">Absences</a>
        <a href="#" class="sidebar-item">Convocations</a>
    </div>

    <div class="content">
        <div class="container mt-5">
            <h1 id="main-title">Téléversement des données des élèves</h1>
            <div class="mt-4">
               
                
                <div id="form-classes" class="form-section">
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

    <script>
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