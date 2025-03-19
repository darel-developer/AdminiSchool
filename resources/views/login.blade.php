<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .gradient-custom-2 {
            /* fallback for old browsers */
            background: #fccb90;

            /* Chrome 10-25, Safari 5.1-6 */
            background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }

        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }

        /* Styles pour l'animation de chargement */
        .wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff;
            display: none; /* Masquer par défaut */
            z-index: 9999; /* Assurez-vous que l'animation est au-dessus de tout le reste */
        }

        .rubik-loader {
            width: 64px;
            height: 64px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-image: url('http://i.giphy.com/3og0ISeflb7vrNzy2A.gif');
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
</head>
<body>
    <!-- Animation de chargement -->
    <div class="wrapper">
        <div class="rubik-loader"></div>
    </div>

    <section class="h-300 gradient-form" style="background-color: #FFF;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
              <div class="card rounded-3 text-black">
                <div class="row g-0">
                  <div class="col-lg-6">
                    <div class="card-body p-md-5 mx-md-4">
      
                      <div class="text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/lotus.webp"
                          style="width: 185px;" alt="logo">
                        <h4 class="mt-1 mb-5 pb-1">We are The AdminiSchool Team</h4>
                      </div>
      
                      <form id="loginForm" action="/login/traitement" method="POST">
                        @csrf
                        <p>Please login to your account</p>
      
                        <div data-mdb-input-init class="form-outline mb-4">
                          <input type="email" id="form2Example11" class="form-control"
                            placeholder="Phone number or email address" name="username" required />
                          <label class="form-label" for="form2Example11">Username</label>
                        </div>
      
                        <div data-mdb-input-init class="form-outline mb-4">
                          <input type="password" id="form2Example22" class="form-control" name="password" required />
                          <label class="form-label" for="form2Example22">Password</label>
                        </div>
                        
                        <div class="form-check mb-4">
                          <input class="form-check-input" type="checkbox" id="rememberMe" name="remember">
                          <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
                        </div>

                        <div class="text-center pt-1 mb-5 pb-1">
                          <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Log
                            in</button> 
                          <a class="text-muted" href="{{ route('password') }}">Forgot password?</a>
                        </div>
      
                        <div class="d-flex align-items-center justify-content-center pb-4">
                          <p class="mb-0 me-2">Don't have an account?</p>
                          <a  href="" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger">Create new</a>
                        </div>
      
                      </form>
      
                    </div>
                  </div>
                  <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                    <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                      <h4 class="mb-4">We are more than just a company</h4>
                      <p class="small mb-0"><font color="black"></font></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche la soumission immédiate du formulaire
            document.querySelector('.wrapper').style.display = 'block'; // Affiche l'animation de chargement

            // Simule un délai de 15 secondes avant de soumettre le formulaire
            setTimeout(function() {
                event.target.submit(); // Soumet le formulaire après le délai
            }, 15000); // 15000 millisecondes = 15 secondes
        });
      </script>
</body>
</html>