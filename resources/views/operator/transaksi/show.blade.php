{{-- resources/views/operator/transaksi/show.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/operator/transaksi" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Detail Order</h4>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-dark text-white">Info Order</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <td class="text-muted">Kode Order</td>
                        <td><strong>{{ $order->order_code }}</strong></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Customer</td>
                        <td>{{ $order->customer->customer_name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">No Telp</td>
                        <td>{{ $order->customer->phone }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tgl Masuk</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tgl Selesai</td>
                        <td>{{ \Carbon\Carbon::parse($order->order_end_date)->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            @if($order->order_status == 0)
                                <span class="badge bg-warning text-dark">Baru / Belum Diambil</span>
                            @else
                                <span class="badge bg-success">Sudah Diambil</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">Detail Item</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>Jenis Service</th>
                            <th class="text-center">Berat (kg)</th>
                            <th class="text-center">Harga/kg</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->service->service_name }}</td>
                            <td class="text-center">{{ $detail->qty }} kg</td>
                            <td class="text-center">
                                Rp {{ number_format($detail->service->price, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="3" class="text-end fw-bold">TOTAL</td>
                            <td class="text-end fw-bold">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>

                @if($order->order_status == 0)
                <div class="text-end mt-2">
                    <a href="/operator/pickup/{{ $order->id }}"
                       class="btn btn-success">
                        <i class="bi bi-bag-check me-1"></i>Proses Pickup
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection