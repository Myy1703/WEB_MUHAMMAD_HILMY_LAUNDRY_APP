{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.app')
@section('content')

<h4 class="mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h4>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ $totalCustomer }}</div>
                    <div>Total Customer</div>
                </div>
                <i class="bi bi-people fs-1 opacity-50"></i>
            </div>
            <a href="/admin/customer" class="card-footer text-white text-decoration-none small">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ $totalUser }}</div>
                    <div>Total User</div>
                </div>
                <i class="bi bi-person-gear fs-1 opacity-50"></i>
            </div>
            <a href="/admin/user" class="card-footer text-white text-decoration-none small">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ $totalService }}</div>
                    <div>Jenis Service</div>
                </div>
                <i class="bi bi-tags fs-1 opacity-50"></i>
            </div>
            <a href="/admin/service" class="card-footer text-white text-decoration-none small">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ $totalOrder }}</div>
                    <div>Order Hari Ini</div>
                </div>
                <i class="bi bi-cart-check fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

@endsection