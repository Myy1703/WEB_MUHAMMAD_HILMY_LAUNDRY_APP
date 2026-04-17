{{-- resources/views/operator/transaksi/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-cart-plus me-2"></i>Daftar Order Masuk</h4>
    <a href="/operator/transaksi/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Buat Transaksi Baru
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Order</th>
                    <th>Customer</th>
                    <th>Tgl Masuk</th>
                    <th>Tgl Selesai</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $i => $order)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="badge bg-secondary">{{ $order->order_code }}</span></td>
                    <td>{{ $order->customer->customer_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_end_date)->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                    <td>
                        @if($order->order_status == 0)
                            <span class="badge bg-warning text-dark">Baru</span>
                        @else
                            <span class="badge bg-success">Sudah Diambil</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/operator/transaksi/{{ $order->id }}"
                           class="btn btn-sm btn-info text-white">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection