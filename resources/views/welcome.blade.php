<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="{{ asset('images/logo_title.png') }}" type="image/x-icon" />
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#2c3e50">
  <style>
    /* Global Styles */
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
    }

    .image-section {
      position: relative;
      width: 100%;
      height: 100vh;
      overflow: hidden;
    }

    .image-section img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .text-overlay {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 5vw;
      opacity: 0.8;
      text-align: center;
      font-weight: bold;
      z-index: 1;
    }

    .navbar {
      background-color: rgba(255, 255, 255, 0.8);
      z-index: 2;
    }

    .navbar-brand img {
      width: 50px; /* Adjust the width */
      height: auto; /* Maintain aspect ratio */
    }

    .about {
      background-color: #fff;
      padding: 40px 20px;
      z-index: 2;
    }

    .about h3 {
      font-size: 30px;
      font-weight: bold;
      color: #333;
      text-align: center;
      margin-bottom: 20px;
    }

    .about p {
      text-align: center;
      font-size: 1.1rem;
      color: #555;
    }

    /* Responsiveness */
    @media (max-width: 768px) {
      .text-overlay {
        font-size: 8vw;
      }

      .about h3 {
        font-size: 24px;
      }

      .about p {
        font-size: 1rem;
      }
    }

    /* Section A propos */
    .propos {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
      width: 100%;
      margin-top: 40px;
      flex-wrap: wrap;
    }

    .propos .left,
    .propos .right {
      width: 48%;
    }

    .propos img {
      width: 100%;
      height: auto;
      max-width: 350px;
      max-height: 350px;
    }

    .propos .left {
      padding: 0;
    }

    @media only screen and (max-width: 900px) {
      .propos {
        font-size: small;
      }
    }

    @media only screen and (max-width: 750px) {
      .propos {
        flex-direction: column;
      }

      .propos .left,
      .propos .right {
        width: 100%;
      }
    }

    /* Section Fonctionnalité */
    .features-section {
      padding: 60px 20px;
      text-align: center;
    }

    .features-section h3 {
      font-size: 30px;
      font-weight: bold;
      color: #333;
      margin-bottom: 40px;
    }

    .feature-box {
      display: inline-block;
      width: 30%;
      margin: 10px;
      padding: 30px;
      border-radius: 15px;
      background-color: #fff;
      border: 2px solid black;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-box img {
      width: 80px;
      height: 80px;
      margin-bottom: 20px;
    }

    .feature-box p {
      font-size: 1.1rem;
      color: #555;
    }

    /* Animation on Hover */
    .feature-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    @media only screen and (max-width: 750px) {
      .feature-box {
        width: 80%;
      }
    }

 /* Témoignages Section */
.testimonial-card {
  width: 45%;
  min-height: 300px;
  border: none;
  border-radius: 20px;
  background-color: #fff;
  display: flex;
  border: 2px solid black;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.testimonial-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.circle img {
  border: 3px solid #ddd;
  padding: 3px;
  background: white;
}

/* Responsiveness */
@media (max-width: 768px) {
  .testimonial-card {
    width: 100%;
  }
}


  </style>
</head>

<body>


 <!-- Navbar -->
 <nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
      <a class="navbar-brand" href="#">
      <img src="{{ asset('images/logo_title.png') }}" alt="logo"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
              <li class="nav-item">
                  <a class="nav-link active" href="#">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="#">Contact</a>
              </li>
          </ul>
          <!-- Dropdown Account (aligné à droite avec ms-auto) -->
          <ul class="navbar-nav ms-auto">
              <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Account
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li><a class="dropdown-item" href="{{ route('ParentRegister') }}"> Parent</a></li>
                      <li><a class="dropdown-item" href="{{ route('SchoolRegister') }}"> École</a></li>
                  </ul>
              </li>
          </ul>
          <!-- Bouton Login -->
          <button class="btn btn-primary ms-3" onclick="window.location.href='{{ route('login') }}'">Login</button>
      </div>
  </div>
</nav>




  <!-- Image avec Texte -->
  <div class="image-section">
    <img src="{{ asset('images/background.png') }}" alt="Image" class="img-fluid">
    <div class="text-overlay">
      <p>ADMINISCHOOL</p>
    </div>
  </div>

  <!-- Section "About" -->
  <div class="container-fluid">
    <section class="about">
      <h3>QUI SOMMES NOUS ?</h3>
      <section class="propos">
        <div class="right">
          <img src="{{ asset('images/image-prpors.png') }}" alt="image" />
        </div>
        <div class="left">
          <p class="texte">
            AdminiSchool est une  structure camerounaise conçue pour renforcer la communication interactive entre l’administration scolaire et les parents . Elle offre une plateforme qui permet aux parents de suivre de près le comportement, les performances académiques et la discipline de leurs enfants en temps réel. Ce système vise à améliorer la transparence, à faciliter l’échange d’informations et à engager davantage les parents dans le suivi de l’éducation de leurs enfants
          </p>
        </div>
      </section>
    </section>
  </div>

  <!-- Section Fonctionnalités -->
  <div class="features-section">
    <h3>Nos Fonctionnalités</h3>
    <div class="feature-box">
      <img src="{{ asset('images/fonc1.png') }}" alt="Fonctionnalité 1">
      <p>Suivi de l'enfant</p>
      <p>
        plateforme permettant 
        
        
        de savoir plus sur son 
        
        
        enfant</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/fonc2.png') }}" alt="Fonctionnalité 2">
      <p>Communication parent

          
        & 
        administration
    </p>
      <p>Meilleur communication sur



        les informations liés à l’école
        
        
        
        avec les parents</p>
    </div>
    <div class="feature-box">
      <img src="{{ asset('images/fonc3.png') }}" alt="Fonctionnalité 3">
      <p>Sécurité & fiabilité</p>
      <p>Les données que nous



        utilisons sont fortement 
        
        
        
        protégés </p>
    </div>

    
  </div>

  <!-- Section Témoignages -->
<div class="container my-5">
    <h3 class="text-center mb-4 fw-bold">Témoignages</h3>
    <div class="d-flex flex-wrap justify-content-center gap-4">
      <!-- Témoignage 1 -->
      <div class="card testimonial-card p-4 shadow-sm">
        <div class="circle mx-auto">
          <img src="{{ asset('images/profil1.png') }}" alt="Parent 1" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <h5 class="text-center mt-3">Marie Dupont</h5>
        <p class="text-muted text-center mb-1">Parent</p>
        <p class="text-center">"AdminiSchool m'a permis de mieux suivre la scolarité de mes enfants. Un outil indispensable !"</p>
      </div>
      <!-- Témoignage 2 -->
      <div class="card testimonial-card p-4 shadow-sm">
        <div class="circle mx-auto">
          <img src="{{ asset('images/profil2.png') }}" alt="Parent 2" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <h5 class="text-center mt-3">Jean Mbarga</h5>
        <p class="text-muted text-center mb-1">Parent</p>
        <p class="text-center">"Une solution fiable et pratique pour rester informé en temps réel."</p>
      </div>
      <!-- Témoignage 3 -->
      <div class="card testimonial-card p-4 shadow-sm">
        <div class="circle mx-auto">
          <img src="{{ asset('images/profil3.png') }}" alt="Parent 3" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <h5 class="text-center mt-3">Fatima Njoya</h5>
        <p class="text-muted text-center mb-1">Parent</p>
        <p class="text-center">"Grâce à AdminiSchool, je suis plus impliquée dans la vie scolaire de mes enfants."</p>
      </div>
      <!-- Témoignage 4 -->
      <div class="card testimonial-card p-4 shadow-sm">
        <div class="circle mx-auto">
          <img src="{{ asset('images/profil4.png') }}" alt="Parent 4" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <h5 class="text-center mt-3">Pauline Tamba</h5>
        <p class="text-muted text-center mb-1">Parent</p>
        <p class="text-center">"L'interface est intuitive et facilite la communication avec l'école."</p>
      </div>
    </div>
  </div>
  
    
  </div>
  

  <!-- Script Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>