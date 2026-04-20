{{-- resources/views/admin/customer/edit.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/admin/customer" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Edit Customer</h4>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="/admin/customer/{{ $customer->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Customer</label>
                <input type="text" name="customer_name"
                    class="form-control @error('customer_name') is-invalid @enderror"
                    value="{{ old('customer_name', $customer->customer_name) }}">
                @error('customer_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">No Telepon</label>
                <input type="text" name="phone"
                    class="form-control"
                    value="{{ old('phone', $customer->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Alamat</label>
                <textarea name="address" rows="3"
                    class="form-control">{{ old('address', $customer->address) }}</textarea>
            </div>

            {{-- 
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_member" class="form-check-input" id="is_member" {{ $customer->is_member ? 'checked' : '' }}>
                <label class="form-check-label fw-bold" for="is_member">Jadikan Member Pribadi (Diskon {{ env('DISKON_MEMBER', 5) }}%)</label>
            </div>
            --}}

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="/admin/customer" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection