@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-ticket-perforated me-2"></i>Kelola Voucher</h4>
    <a href="/admin/voucher/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>Buat Voucher
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Voucher</th>
                    <th>Deskripsi</th>
                    <th>Expired Date</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($vouchers as $i => $v)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="fw-bold">{{ $v->voucher_code }}</td>
                    <td>{{ $v->description }}</td>
                    <td>{{ date('d-m-Y', strtotime($v->valid_until)) }}</td>
                    <td>
                        @if($v->is_active && strtotime($v->valid_until) >= strtotime(date('Y-m-d')))
                            <span class="badge bg-success">Aktif</span>
                        @elseif(!$v->is_active)
                            <span class="badge bg-danger">Nonaktif</span>
                        @else
                            <span class="badge bg-secondary">Expired</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="/admin/voucher/{{ $v->id }}/edit" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="/admin/voucher/{{ $v->id }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus voucher ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data voucher</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
