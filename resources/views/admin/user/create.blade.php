{{-- resources/views/admin/user/create.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/admin/user" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Tambah User Baru</h4>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="/admin/user" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Password</label>
                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Role</label>
                <select name="role_id"
                    class="form-select @error('role_id') is-invalid @enderror">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->roles_name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>Simpan
                </button>
                <a href="/admin/user" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection