<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | AppointmentScheduler</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0ea5e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0,0,0,.3);
            overflow: hidden;
            max-width: 440px;
            width: 100%;
        }
        .auth-header {
            background: linear-gradient(135deg, #0f172a, #0ea5e9);
            padding: 30px;
            text-align: center;
        }
        .auth-header h2 { color: #fff; font-weight: 800; }
        .auth-header p  { color: #bae6fd; font-size: .9rem; }
        .auth-body { padding: 30px; }
        .form-control:focus { border-color: #0ea5e9; box-shadow: 0 0 0 .2rem rgba(14,165,233,.25); }
        .btn-primary { background: #0ea5e9; border-color: #0ea5e9; font-weight: 600; }
        .btn-primary:hover { background: #0284c7; border-color: #0284c7; }
        .form-label { font-weight: 600; font-size: .88rem; color: #374151; }
        .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        a { color: #0ea5e9; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="toast-container">
                @if(session('toast_success'))
                <div class="toast align-items-center text-bg-success border-0 show" role="alert">
                    <div class="d-flex">
                        <div class="toast-body"><i class="bi bi-check-circle-fill me-2"></i>{{ session('toast_success') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
                @endif
            </div>
            <div class="auth-card">
                @yield('content')
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.toast').forEach(t => {
        setTimeout(() => bootstrap.Toast.getOrCreateInstance(t).hide(), 4000);
    });
</script>
</body>
</html>
