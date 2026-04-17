@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/admin/voucher" class="btn btn-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Buat Voucher Baru</h4>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="/admin/voucher" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Kode Voucher <span class="text-danger">*</span></label>
                <input type="text" name="voucher_code" class="form-control @error('voucher_code') is-invalid @enderror" value="{{ old('voucher_code') }}" placeholder="Contoh: PROMOJUARA">
                @error('voucher_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Promo</label>
                <textarea name="description" class="form-control" rows="2">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Berlaku Sampai (Expired Date) <span class="text-danger">*</span></label>
                <input type="date" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{ old('valid_until') }}">
                @error('valid_until') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                <label class="form-check-label fw-bold text-success" for="is_active">Aktifkan Voucher</label>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="/admin/voucher" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
