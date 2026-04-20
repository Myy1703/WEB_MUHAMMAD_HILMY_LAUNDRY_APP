{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Laundry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            padding-top: 20px;
        }
        .sidebar a {
            color: #bdc3c7;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 14px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #34495e;
            color: white;
        }
        .sidebar .menu-title {
            color: #7f8c8d;
            font-size: 11px;
            padding: 15px 20px 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .navbar-brand { font-weight: bold; }
        .main-content { padding: 25px; }
    </style>
</head>
<body>

{{-- NAVBAR ATAS --}}
<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">
        <i class="bi bi-droplet-fill text-info"></i> Laundry App
    </span>
    <div class="d-flex align-items-center gap-3">
        <span class="text-white small">
            <i class="bi bi-person-circle"></i>
            {{ session('user')['name'] }} —
            <span class="badge bg-info">{{ session('user')['role'] }}</span>
        </span>
        <a href="/logout" class="btn btn-sm btn-outline-danger">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR KIRI --}}
        <div class="col-md-2 p-0 sidebar">

            {{-- Menu Admin --}}
            @if(session('user')['role'] == 'Admin')
                <div class="menu-title">Master Data</div>
                <a href="/admin/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a href="/admin/customer"><i class="bi bi-people me-2"></i>Customer</a>
                <a href="/admin/user"><i class="bi bi-person-gear me-2"></i>User</a>
                <a href="/admin/service"><i class="bi bi-tags me-2"></i>Jenis Service</a>
                {{-- <a href="/admin/voucher"><i class="bi bi-ticket-perforated me-2"></i>Voucher Diskon</a> --}}
                <div class="menu-title">Transaksi</div>
                <a href="/operator/transaksi"><i class="bi bi-cart-plus me-2"></i>Transaksi</a>
                <a href="/operator/pickup"><i class="bi bi-bag-check me-2"></i>Pickup</a>
            @endif

            {{-- Menu Operator --}}
            @if(session('user')['role'] == 'Operator')
                <div class="menu-title">Transaksi</div>
                <a href="/operator/dashboard"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                <a href="/operator/transaksi"><i class="bi bi-cart-plus me-2"></i>Order Masuk</a>
                <a href="/operator/pickup"><i class="bi bi-bag-check me-2"></i>Pickup Pakaian</a>
            @endif

            {{-- Menu Pimpinan --}}
            @if(session('user')['role'] == 'Pimpinan')
                <div class="menu-title">Laporan</div>
                <a href="/pimpinan/laporan"><i class="bi bi-bar-chart me-2"></i>Laporan Penjualan</a>
            @endif

        </div>

        {{-- KONTEN UTAMA --}}
        <div class="col-md-10 main-content">

            {{-- Flash Message --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>