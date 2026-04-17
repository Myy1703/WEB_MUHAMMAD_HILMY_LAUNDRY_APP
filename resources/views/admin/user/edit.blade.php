{{-- resources/views/admin/user/edit.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex align-items-center mb-4">
    <a href="/admin/user" class="btn btn-secondary me-3">
        <i class="bi bi-arrow-left"></i>
    </a>
    <h4 class="mb-0">Edit User</h4>
</div>

<div class="card shadow-sm" style="max-width: 600px;">
    <div class="card-body">
        <form action="/admin/user/{{ $user->id }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                    value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    Password
                    <small class="text-muted fw-normal">(Kosongkan jika tidak diubah)</small>
                </label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Level</label>
                <select name="role_id" class="form-select">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ $user->role_id == $role->id ? 'selected' : '' }}>
                            {{ $role->roles_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-save me-1"></i>Update
                </button>
                <a href="/admin/user" class="btn btn-secondary">Batal</a>
            </div>

        </form>
    </div>
</div>

@endsection