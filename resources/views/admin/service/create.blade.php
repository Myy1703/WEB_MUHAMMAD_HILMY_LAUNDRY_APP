{{-- resources/views/admin/service/create.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/admin/service" class="btn btn-secondary me-3"><i class="bi bi-arrow-left"></i></a>
    <h4 class="mb-0">Tambah Jenis Service</h4>
</div>

<div class="card shadow-sm" style="max-width:600px;">
    <div class="card-body">
        <form action="/admin/service" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Service</label>
                <input type="text" name="service_name" class="form-control"
                    value="{{ old('service_name') }}" placeholder="Contoh: Cuci dan Gosok">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Harga per Kg (Rp)</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" name="price" class="form-control"
                        value="{{ old('price') }}" placeholder="5000">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi</label>
                <textarea name="description" rows="2" class="form-control"
                    placeholder="Keterangan singkat service ini">{{ old('description') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="/admin/service" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection