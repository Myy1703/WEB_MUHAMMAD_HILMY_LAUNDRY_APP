{{-- resources/views/operator/pickup/show.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/operator/pickup" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Proses Pengambilan Pakaian</h4>
</div>

<div class="row">

    {{-- Detail Order --}}
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-info text-white fw-bold">
                <i class="bi bi-receipt me-2"></i>Detail Order
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Kode:</strong> {{ $order->order_code }}</p>
                <p class="mb-1"><strong>Customer:</strong> {{ $order->customer->customer_name }}</p>
                <p class="mb-3"><strong>Telepon:</strong> {{ $order->customer->phone }}</p>

                <table class="table table-sm table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th>Service</th>
                            <th>Berat</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                        <tr>
                            <td>{{ $detail->service->service_name }}</td>
                            <td>{{ $detail->qty }} kg</td>
                            <td class="text-end">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-dark">
                            <td colspan="2" class="fw-bold">TOTAL TAGIHAN</td>
                            <td class="text-end fw-bold">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Form Pembayaran --}}
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                <i class="bi bi-cash-coin me-2"></i>Form Pembayaran
            </div>
            <div class="card-body">
                <form action="/operator/pickup/{{ $order->id }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Total Tagihan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control bg-light fw-bold text-success"
                                value="{{ number_format($order->total, 0, ',', '.') }}" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Uang Bayar <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="order_pay" id="input-bayar"
                                class="form-control"
                                min="{{ $order->total }}"
                                placeholder="Masukkan nominal uang"
                                oninput="hitungKembalian({{ $order->total }})"
                                required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Kembalian</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="label-kembalian"
                                class="form-control bg-light fw-bold text-primary"
                                value="0" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catatan (opsional)</label>
                        <textarea name="notes" rows="2" class="form-control"
                            placeholder="Catatan pickup..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        <i class="bi bi-check-circle me-1"></i>Konfirmasi Pickup
                    </button>

                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
function hitungKembalian(total) {
    const bayar     = parseInt(document.getElementById('input-bayar').value) || 0;
    const kembalian = bayar - total;
    const el        = document.getElementById('label-kembalian');

    if (kembalian < 0) {
        el.value = 'Uang kurang!';
        el.classList.add('text-danger');
        el.classList.remove('text-primary');
    } else {
        el.value = kembalian.toLocaleString('id-ID');
        el.classList.remove('text-danger');
        el.classList.add('text-primary');
    }
}
</script>
@endsection