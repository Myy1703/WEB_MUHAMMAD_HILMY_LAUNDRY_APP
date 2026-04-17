{{-- resources/views/admin/service/index.blade.php --}}
@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-tags me-2"></i>Jenis Service</h4>
    <a href="/admin/service/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Tambah Service
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Service</th>
                    <th>Harga / kg</th>
                    <th>Deskripsi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $i => $service)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $service->service_name }}</td>
                    <td>Rp {{ number_format($service->price, 0, ',', '.') }}</td>
                    <td>{{ $service->description }}</td>
                    <td class="text-center">
                        <a href="/admin/service/{{ $service->id }}/edit"
                           class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/admin/service/{{ $service->id }}"
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus service ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">Belum ada data service</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection