{{-- resources/views/pimpinan/laporan/index.blade.php --}}
@extends('layouts.app')
@section('content')

<h4 class="mb-4"><i class="bi bi-bar-chart me-2"></i>Laporan Penjualan</h4>

{{-- Form Filter Tanggal --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="/pimpinan/laporan" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="dari" class="form-control"
                    value="{{ request('dari') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control"
                    value="{{ request('sampai') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i>Filter
                </button>
            </div>
            <div class="col-md-2">
                <a href="/pimpinan/laporan" class="btn btn-secondary w-100">
                    <i class="bi bi-x-circle me-1"></i>Reset
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</div>
                <div>Total Omzet</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold">{{ $orders->count() }}</div>
                <div>Total Transaksi</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark shadow-sm">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold">
                    {{ $orders->sum(fn($o) => $o->details->sum('qty')) }} kg
                </div>
                <div>Total Berat Laundry</div>
            </div>
        </div>
    </div>
</div>

{{-- Tabel Laporan --}}
<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        Detail Transaksi Selesai
    </div>
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Tgl Order</th>
                    <th>Item Service</th>
                    <th class="text-end">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $i => $order)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="badge bg-secondary">{{ $order->order_code }}</span></td>
                    <td>{{ $order->customer->customer_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td>
                        @foreach($order->details as $detail)
                            <span class="badge bg-light text-dark border">
                                {{ $detail->service->service_name }}
                                {{ $detail->qty }}kg
                            </span>
                        @endforeach
                    </td>
                    <td class="text-end fw-bold text-success">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Belum ada data transaksi selesai
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($orders->count() > 0)
            <tfoot>
                <tr class="table-success">
                    <td colspan="5" class="text-end fw-bold">TOTAL OMZET</td>
                    <td class="text-end fw-bold">
                        Rp {{ number_format($totalOmzet, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection