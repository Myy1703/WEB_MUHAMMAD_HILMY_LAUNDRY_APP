{{-- resources/views/admin/user/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person-gear me-2"></i>Data User</h4>
    <a href="/admin/user/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah User
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge
                            @if($user->role->roles_name == 'Admin') bg-danger
                            @elseif($user->role->roles_name == 'Operator') bg-warning text-dark
                            @else bg-info
                            @endif">
                            {{ $user->role->roles_name }}
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="/admin/user/{{ $user->id }}/edit"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/admin/user/{{ $user->id }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus user ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data user</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection