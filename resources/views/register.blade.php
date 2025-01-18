<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .gradient-custom-2 {
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
    </style>
</head>
<body>
    <section class="h-300 gradient-form" style="background-color:    ">
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
                                    @if(session('status'))
                                        <div class="alert alert-success">
                                            {{session('status')}}
                                        </div>
                                    @endif

                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="alert alert-danger"> {{$error}}</li>
                                        @endforeach
                                    </ul>
                                    <form method="POST" action="/register/traitement">
                                        @csrf
                                        <p>Please Sing In to your account</p>
                                        <div class="row mb-4" id="nameFields">
                                            <div class="col">
                                                <div class="form-outline">
                                                    <input type="text" id="firstName" name="firstName" class="form-control" placeholder="First Name" value="{{ old('firstName') }}" required />
                                                    <label class="form-label" for="firstName">First Name</label>
                                                    @error('firstName')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-outline">
                                                    <input type="text" id="secondName" name="secondName" class="form-control" placeholder="Second Name" value="{{ old('secondName') }}" required />
                                                    <label class="form-label" for="secondName">Second Name</label>
                                                    @error('secondName')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-outline mb-4 d-none" id="schoolNameField">
                                            <input type="text" id="schoolName" name="SchoolName" class="form-control" placeholder="School Name" value="{{ old('schoolName') }}" required/>
                                            <label class="form-label" for="schoolName">School Name</label>
                                            @error('SchoolName')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                       <div class="form-outline mb-4 d-none" id="childNameField">
    <input type="text" id="childName" name="childName" class="form-control" placeholder="Child's Name" value="{{ old('childName') }}" />
    <label class="form-label" for="childName">Child's Name</label>
    @error('childName')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-outline mb-4 d-none" id="schoolDropdownField">
    <select id="schoolName" name="schoolName" class="form-select"> <!-- Mise à jour ici -->
        <option value="">Select a School</option>
        <option value="School A" {{ old('schoolName') == 'School A' ? 'selected' : '' }}>School A</option>
        <option value="School B" {{ old('schoolName') == 'School B' ? 'selected' : '' }}>School B</option>
        <option value="School C" {{ old('schoolName') == 'School C' ? 'selected' : '' }}>School C</option>
    </select>
    <label class="form-label" for="schoolName">School</label> <!-- Mise à jour ici -->
    @error('schoolName')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

                                        
                                        
                                        <div class="mb-4">
                                            <p class="mb-1">Select Account Type:</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="accountType" id="parent" value="parent" {{ old('accountType') == 'parent' ? 'checked' : '' }} onclick="toggleFields('parent')" />
                                                <label class="form-check-label" for="parent">Parent</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="accountType" id="school" value="school" {{ old('accountType') == 'school' ? 'checked' : '' }} onclick="toggleFields('school')" />
                                                <label class="form-check-label" for="school">School</label>
                                            </div>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="email" id="username" name="username" class="form-control" placeholder="Phone number or email address" value="{{ old('username') }}" required/>
                                            <label class="form-label" for="username">Username</label>
                                            @error('username')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="********" required/>
                                            <label class="form-label" for="password">Password</label>
                                            @error('password')
                                                 <div class="text-danger">{{ $message }}</div>
                                             @enderror
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="password_confirmation"  name="password_confirmation" class="form-control" placeholder="********" required />
                                            <label class="form-label" for="password">Repeat Password</label>
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button type="submit" class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3">Sign up</button>
                                        </div>
                                        
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4">We are more than just a company</h4>
                                    <p class="small mb-0"></p>
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
    function toggleFields(accountType) {
    const nameFields = document.getElementById('nameFields');
    const schoolNameField = document.getElementById('schoolNameField');
    const childNameField = document.getElementById('childNameField');
    const schoolDropdownField = document.getElementById('schoolDropdownField');

    if (accountType === 'school') {
        // School account: Hide parent-specific fields
        nameFields.querySelectorAll('input').forEach(input => input.required = false);
        childNameField.querySelector('input').required = false;
        schoolDropdownField.querySelector('select').required = false;

        nameFields.classList.add('d-none');
        childNameField.classList.add('d-none');
        schoolDropdownField.classList.add('d-none');
        schoolNameField.querySelector('input').required = true;
        schoolNameField.classList.remove('d-none');
    } else {
        // Parent account: Show parent-specific fields
        nameFields.querySelectorAll('input').forEach(input => input.required = true);
        childNameField.querySelector('input').required = true;
        schoolDropdownField.querySelector('select').required = true;

        nameFields.classList.remove('d-none');
        childNameField.classList.remove('d-none');
        schoolDropdownField.classList.remove('d-none');
        schoolNameField.querySelector('input').required = false;
        schoolNameField.classList.add('d-none');
    }
}


</script>

</body>
</html>