{{-- resources/views/operator/transaksi/create.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/operator/transaksi" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Buat Transaksi Baru</h4>
</div>

<form action="/operator/transaksi" method="POST" id="form-transaksi">
@csrf

<div class="row">

    {{-- KOLOM KIRI: Info Order --}}
    <div class="col-md-5">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white fw-bold">
                <i class="bi bi-person-check me-2"></i>Informasi Customer
            </div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label fw-bold">Tipe Customer</label>
                    <div class="p-2 border rounded bg-light">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe_customer" id="tipe_terdaftar" value="terdaftar" checked onchange="toggleTipeCustomer()">
                            <label class="form-check-label fw-bold text-primary" for="tipe_terdaftar">
                                <i class="bi bi-card-list"></i> Customer Terdaftar / Member
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe_customer" id="tipe_baru" value="baru" onchange="toggleTipeCustomer()">
                            <label class="form-check-label fw-bold text-secondary" for="tipe_baru">
                                <i class="bi bi-person-plus"></i> Non-Member (Baru)
                            </label>
                        </div>
                    </div>
                </div>

                <div id="div_customer_terdaftar" class="mb-3">
                    <label class="form-label fw-bold">Pilih Customer</label>
                    <select id="customer_select" name="id_customer" class="form-select" onchange="hitungTotal()">
                        <option value="">-- Pilih Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" data-member="{{ $customer->is_member ? '1' : '0' }}">
                                {{ $customer->customer_name }} ({{ $customer->phone }}) 
                                {{ $customer->is_member ? '[MEMBER]' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        <span id="badge-member" class="badge bg-success d-none"><i class="bi bi-star-fill"></i> Member Pribadi</span>
                    </div>
                </div>

                <div id="div_customer_baru" class="d-none mb-3 p-3 border rounded">
                    <div class="mb-2">
                        <label class="form-label fw-bold small mb-1">Nama Lengkap</label>
                        <input type="text" name="customer_name" id="input_cust_name" class="form-control form-control-sm" placeholder="Nama Non-Member">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold small mb-1">No HP / WA</label>
                        <input type="text" name="phone" id="input_cust_phone" class="form-control form-control-sm" placeholder="08xxxxxxxx">
                    </div>
                    <div>
                        <label class="form-label fw-bold small mb-1">Alamat</label>
                        <textarea name="address" id="input_cust_address" class="form-control form-control-sm" rows="2" placeholder="Alamat lengkap"></textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Masuk</label>
                    <input type="date" name="order_date" class="form-control"
                        value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Estimasi Tanggal Selesai</label>
                    <input type="date" name="order_end_date" class="form-control"
                        value="{{ date('Y-m-d', strtotime('+2 days')) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Voucher</label>
                    <div class="input-group">
                        <input type="text" id="voucher_input" class="form-control" placeholder="Masukkan kode">
                        <button type="button" class="btn btn-outline-primary" onclick="cekVoucher()">Pakai</button>
                    </div>
                    <small id="voucher_msg" class="d-block mt-1 fw-bold"></small>
                    <input type="hidden" id="voucher_verified" name="voucher_code" value="">
                </div>

            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: Item Service --}}
    <div class="col-md-7">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold d-flex justify-content-between">
                <span><i class="bi bi-list-check me-2"></i>Item Laundry</span>
                <button type="button" class="btn btn-sm btn-light" onclick="tambahBaris()">
                    <i class="bi bi-plus"></i> Tambah Item
                </button>
            </div>
            <div class="card-body">

                <table class="table table-bordered" id="tabel-item">
                    <thead class="table-secondary">
                        <tr>
                            <th>Jenis Service</th>
                            <th width="100">Berat (kg)</th>
                            <th width="120">Subtotal</th>
                            <th width="40"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody-item">
                        {{-- Baris pertama default --}}
                        <tr class="baris-item">
                            <td>
                                <select name="services[0][id_service]"
                                    class="form-select form-select-sm select-service"
                                    onchange="hitungSubtotal(this)" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}"
                                            data-harga="{{ $service->price }}">
                                            {{ $service->service_name }}
                                            (Rp {{ number_format($service->price,0,',','.') }}/kg)
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="services[0][qty]"
                                    class="form-control form-control-sm input-qty"
                                    min="1" value="1"
                                    onchange="hitungSubtotal(this)" required>
                            </td>
                            <td>
                                <input type="text"
                                    class="form-control form-control-sm input-subtotal"
                                    readonly value="0">
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="hapusBaris(this)">
                                    <i class="bi bi-x"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- Total --}}
                <div class="text-end mt-2">
                    <h6 class="text-muted">Subtotal: <strong id="label-subtotal">Rp 0</strong></h6>
                    <h6 class="text-success d-none" id="row-member-discount">Diskon Member ({{ env('DISKON_MEMBER', 5) }}%): <strong id="label-member-discount">Rp 0</strong></h6>
                    <h6 class="text-success d-none" id="row-voucher-discount">Diskon Voucher (<span id="txt-voucher-pct">0</span>%): <strong id="label-voucher-discount">Rp 0</strong></h6>
                    <h6 class="text-muted">Pajak ({{ env('PAJAK_LAUNDRY', 10) }}%): <strong class="text-danger" id="label-tax">Rp 0</strong></h6>
                    <hr>
                    <h5>Total Akhir: <strong class="text-primary" id="label-total">Rp 0</strong></h5>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Catatan (opsional)</label>
                    <textarea name="services[0][notes]" class="form-control form-control-sm"
                        rows="2" placeholder="Catatan khusus..."></textarea>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="mt-3 d-flex gap-2">
    <button type="submit" class="btn btn-success btn-lg">
        <i class="bi bi-save me-1"></i>Simpan Transaksi
    </button>
    <a href="/operator/transaksi" class="btn btn-secondary btn-lg">Batal</a>
</div>

</form>

@endsection

@section('scripts')
<script>
// Data service dari PHP ke JavaScript
const services = @json($services);
let indexBaris = 1; // counter index baris

// Fungsi tambah baris item baru
function tambahBaris() {
    const tbody = document.getElementById('tbody-item');
    const tr = document.createElement('tr');
    tr.className = 'baris-item';

    // Buat option service
    let options = '<option value="">-- Pilih --</option>';
    services.forEach(s => {
        options += `<option value="${s.id}" data-harga="${s.price}">
            ${s.service_name} (Rp ${s.price.toLocaleString('id-ID')}/kg)
        </option>`;
    });

    tr.innerHTML = `
        <td>
            <select name="services[${indexBaris}][id_service]"
                class="form-select form-select-sm select-service"
                onchange="hitungSubtotal(this)" required>
                ${options}
            </select>
        </td>
        <td>
            <input type="number" name="services[${indexBaris}][qty]"
                class="form-control form-control-sm input-qty"
                min="1" value="1"
                onchange="hitungSubtotal(this)" required>
        </td>
        <td>
            <input type="text"
                class="form-control form-control-sm input-subtotal"
                readonly value="0">
        </td>
        <td>
            <button type="button" class="btn btn-sm btn-danger"
                onclick="hapusBaris(this)">
                <i class="bi bi-x"></i>
            </button>
        </td>
    `;
    tbody.appendChild(tr);
    indexBaris++;
}

// Fungsi hapus baris
function hapusBaris(btn) {
    const baris = document.querySelectorAll('.baris-item');
    if (baris.length <= 1) {
        alert('Minimal harus ada 1 item!');
        return;
    }
    btn.closest('tr').remove();
    hitungTotal();
}

// Fungsi hitung subtotal per baris
function hitungSubtotal(el) {
    const baris = el.closest('tr');
    const select = baris.querySelector('.select-service');
    const qty    = parseInt(baris.querySelector('.input-qty').value) || 0;
    const harga  = parseInt(select.selectedOptions[0]?.dataset.harga) || 0;
    const sub    = harga * qty;

    baris.querySelector('.input-subtotal').value =
        'Rp ' + sub.toLocaleString('id-ID');

    hitungTotal();
}

const DISKON_MEMBER_PCT = {{ env('DISKON_MEMBER', 5) }};
const DISKON_VOUCHER_MEMBER_PCT = {{ env('DISKON_VOUCHER_MEMBER', 15) }};
const DISKON_VOUCHER_NON_MEMBER_PCT = {{ env('DISKON_VOUCHER_NON_MEMBER', 10) }};
const PAJAK_PCT = {{ env('PAJAK_LAUNDRY', 10) }};

let isVoucherValid = false;

// Fungsi cek status member dari dropdown (hanya jika terdaftar)
function isCustomerMember() {
    const tipe = document.querySelector('input[name="tipe_customer"]:checked').value;
    if (tipe === 'baru') return false; // pelanggan baru otomatis non-member

    const select = document.getElementById('customer_select');
    if (!select.value) return false;
    const option = select.options[select.selectedIndex];
    return option.dataset.member === '1';
}

function toggleTipeCustomer() {
    const tipe = document.querySelector('input[name="tipe_customer"]:checked').value;
    const divTerdaftar = document.getElementById('div_customer_terdaftar');
    const divBaru = document.getElementById('div_customer_baru');
    const select = document.getElementById('customer_select');
    const inputName = document.getElementById('input_cust_name');
    const inputPhone = document.getElementById('input_cust_phone');
    const inputAddress = document.getElementById('input_cust_address');

    if (tipe === 'terdaftar') {
        divTerdaftar.classList.remove('d-none');
        divBaru.classList.add('d-none');
        select.required = true;
        inputName.required = false;
        inputPhone.required = false;
        inputAddress.required = false;
    } else {
        divTerdaftar.classList.add('d-none');
        divBaru.classList.remove('d-none');
        select.required = false;
        inputName.required = true;
        inputPhone.required = true;
        inputAddress.required = true;
    }
    hitungTotal();
}
// inisiasi awal toggle
document.addEventListener("DOMContentLoaded", function() {
    toggleTipeCustomer();
});

function cekVoucher() {
    const code = document.getElementById('voucher_input').value.trim();
    if (!code) {
        alert('Masukkan kode voucher'); return;
    }
    
    fetch('/operator/voucher/check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: code })
    })
    .then(res => res.json())
    .then(data => {
        const msg = document.getElementById('voucher_msg');
        if (data.success) {
            isVoucherValid = true;
            document.getElementById('voucher_verified').value = code;
            msg.className = 'text-success d-block mt-1 fw-bold';
            msg.textContent = 'Voucher diterapkan!';
            hitungTotal();
        } else {
            isVoucherValid = false;
            document.getElementById('voucher_verified').value = '';
            msg.className = 'text-danger d-block mt-1 fw-bold';
            msg.textContent = data.message;
            hitungTotal();
        }
    });
}

// Fungsi hitung total semua baris
function hitungTotal() {
    // 1. Hitung Subtotal Real
    let subtotal = 0;
    document.querySelectorAll('.baris-item').forEach(baris => {
        const select = baris.querySelector('.select-service');
        const qty    = parseInt(baris.querySelector('.input-qty').value) || 0;
        const harga  = parseInt(select.selectedOptions[0]?.dataset.harga) || 0;
        subtotal += harga * qty;
    });

    // 2. Cek Member
    const isMember = isCustomerMember();
    document.getElementById('badge-member').className = isMember ? 'badge bg-success' : 'd-none';

    // 3. Diskon Member
    let diskonMemberNominal = 0;
    if (isMember) {
        diskonMemberNominal = (subtotal * DISKON_MEMBER_PCT) / 100;
        document.getElementById('row-member-discount').className = 'text-success';
    } else {
        document.getElementById('row-member-discount').className = 'd-none';
    }
    
    // 4. Diskon Voucher
    let diskonVoucherNominal = 0;
    let voucherPct = 0;
    if (isVoucherValid) {
        voucherPct = isMember ? DISKON_VOUCHER_MEMBER_PCT : DISKON_VOUCHER_NON_MEMBER_PCT;
        diskonVoucherNominal = (subtotal * voucherPct) / 100;
        document.getElementById('txt-voucher-pct').textContent = voucherPct;
        document.getElementById('row-voucher-discount').className = 'text-success';
    } else {
        document.getElementById('row-voucher-discount').className = 'd-none';
    }
    
    // 5. Total Setelah Diskon Sebelum Pajak
    let totalAfterDiscount = subtotal - diskonMemberNominal - diskonVoucherNominal;
    if (totalAfterDiscount < 0) totalAfterDiscount = 0; // pencegahan mines
    
    // 6. Hitung Pajak (Berdasarkan Subtotal)
    // "Pajak default 10% dari subtotal transaksi" 
    // Rumus Pajak umumnya dikenakan pada subtotal tanpa diskon. Kalau pakai diskon, ya subtotal.
    const taxNominal = (subtotal * PAJAK_PCT) / 100;
    
    // 7. Grand Total
    const grandTotal = totalAfterDiscount + taxNominal;

    document.getElementById('label-subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('label-member-discount').textContent = '-Rp ' + diskonMemberNominal.toLocaleString('id-ID');
    document.getElementById('label-voucher-discount').textContent = '-Rp ' + diskonVoucherNominal.toLocaleString('id-ID');
    document.getElementById('label-tax').textContent = 'Rp ' + taxNominal.toLocaleString('id-ID');
    document.getElementById('label-total').textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
}
</script>
@endsection