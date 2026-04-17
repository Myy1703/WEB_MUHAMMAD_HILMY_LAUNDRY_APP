{{-- resources/views/operator/dashboard.blade.php --}}
@extends('layouts.app')
@section('content')

<h4 class="mb-4"><i class="bi bi-speedometer2 me-2"></i>Dashboard Operator</h4>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ \App\Models\TransOrder::where('order_status', 0)->count() }}</div>
                    <div>Order Baru</div>
                </div>
                <i class="bi bi-cart-plus fs-1 opacity-50"></i>
            </div>
            <a href="/operator/transaksi" class="card-footer text-white text-decoration-none small">
                Lihat Detail <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ \App\Models\TransOrder::where('order_status', 1)->count() }}</div>
                    <div>Sudah Diambil</div>
                </div>
                <i class="bi bi-bag-check fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="fs-4 fw-bold">{{ \App\Models\Customer::count() }}</div>
                    <div>Total Customer</div>
                </div>
                <i class="bi bi-people fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

@endsection
