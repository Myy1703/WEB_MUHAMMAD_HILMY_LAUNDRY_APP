{{-- resources/views/operator/pickup/index.blade.php --}}
@extends('layouts.app')
@section('content')

<h4 class="mb-4"><i class="bi bi-bag-check me-2"></i>Order Siap Diambil</h4>

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
                    <th>Total Tagihan</th>
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
                    <td class="fw-bold text-success">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </td>
                    <td class="text-center">
                        <a href="/operator/pickup/{{ $order->id }}"
                           class="btn btn-sm btn-success">
                            <i class="bi bi-bag-check me-1"></i>Proses Pickup
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Tidak ada order yang menunggu pengambilan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection