{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Laundry App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .card-header {
            background: #2c3e50;
            border-radius: 16px 16px 0 0 !important;
            text-align: center;
            padding: 25px;
        }
    </style>
</head>
<body>

<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h4 class="text-white mb-0">
                <i class="bi bi-droplet-fill text-info"></i> Laundry App
            </h4>
            <small class="text-secondary">Silakan login untuk melanjutkan</small>
        </div>
        <div class="card-body p-4">

            {{-- Tampilkan error jika ada --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="/login" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="contoh@email.com"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Password</label>
                    <input
                        type="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 mt-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Login
                </button>
            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>