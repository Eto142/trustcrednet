<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e54c8 0%, #8f94fb 100%);
            min-height: 100vh;
        }
        .admin-login-card {
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.2);
            background: rgba(255,255,255,0.97);
            padding: 2rem 1.5rem;
        }
        .admin-logo {
            width: 56px;
            height: 56px;
            margin-bottom: 1rem;
        }
        .admin-login-title {
            font-weight: 700;
            letter-spacing: 1px;
        }
        .admin-login-btn {
            font-weight: 600;
            font-size: 1.1rem;
        }
        @media (max-width: 575.98px) {
            .admin-login-card {
                border-radius: 1rem;
                padding: 1.2rem 0.7rem;
            }
            .admin-logo {
                width: 44px;
                height: 44px;
            }
            .admin-login-title {
                font-size: 1.3rem;
            }
            .admin-login-btn {
                font-size: 1rem;
            }
            .col-md-5.col-lg-4 {
                max-width: 100%;
                flex: 0 0 100%;
            }
        }
    </style>
</head>
<body>
@if (!isset($errors))
    @php $errors = session('errors') ?: new \Illuminate\Support\ViewErrorBag; @endphp
@endif
<div class="container d-flex align-items-center justify-content-center" style="min-height:100vh;">
    <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4 px-0">
        <div class="admin-login-card">
            <div class="text-center">
                <img src="https://cdn-icons-png.flaticon.com/512/1828/1828506.png" alt="Admin" class="admin-logo">
                <h2 class="admin-login-title mb-3 text-primary">Admin Login</h2>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif
            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="admin@example.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Enter password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">
                            <span class="fa fa-eye" id="togglePasswordIcon"></span>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary admin-login-btn w-100 mt-2">Login</button>
            </form>
        </div>
    </div>
</div>
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePasswordIcon.classList.toggle('fa-eye');
            togglePasswordIcon.classList.toggle('fa-eye-slash');
        });
    });
</script>
</body>
</html>
