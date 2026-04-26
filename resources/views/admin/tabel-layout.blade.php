@extends('layouts.admin')

@push('styles')
    <style>
        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.03);
        }

        .table-custom th {
            color: #6c757d;
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 1px solid #f3f4f6;
            padding: 1rem;
        }

        .table-custom td {
            vertical-align: middle;
            font-size: 0.9rem;
            color: #4b5563;
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        /* Styling tombol soft color */
        .btn-soft-success {
            background-color: #d1fae5;
            color: #059669;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .btn-soft-success:hover {
            background-color: #a7f3d0;
            color: #047857;
        }

        .btn-soft-danger {
            background-color: #fee2e2;
            color: #dc2626;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .btn-soft-danger:hover {
            background-color: #fecaca;
            color: #b91c1c;
        }
    </style>
@endpush

@section('content')
    <h3 class="fw-bold text-dark mb-4">{{ $title }}</h3>

    <div class="card card-custom bg-white p-2">
        <div class="card-body p-0 overflow-auto">

            <table class="table table-custom mb-0 w-100">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Number Phone</th>
                        <th>Kota Asal</th>
                        <th>Asal Instansi</th>
                        <th class="text-center">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        @php
                            // Jika halaman Persetujuan, ambil data user dari relasi. Jika bukan, ambil langsung.
                            $currentUser = $title == 'Persetujuan Kost' ? $item->user : $item;
                        @endphp

                        <tr>
                            {{-- Gunakan -> bukan [''] untuk konsistensi objek Eloquent --}}
                            <td>{{ $currentUser->name }}</td>
                            <td>{{ $currentUser->email }}</td>

                            {{-- Mengakses userDetail dari currentUser --}}
                            <td>{{ $currentUser->userDetail->phone ?? '-' }}</td>
                            <td>{{ $currentUser->userDetail->city ?? '-' }}</td>
                            <td>{{ $currentUser->userDetail->institution ?? '-' }}</td>

                            <td class="text-center text-nowrap">
                                @if ($title == 'Persetujuan Kost')
                                    <form action="{{ route('admin.approve-role', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-soft-success rounded-pill px-3 py-1 me-1 border-0">Setuju</button>
                                    </form>

                                    <form action="{{ route('admin.reject-role', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-soft-danger rounded-pill px-3 py-1 border-0">Tidak</button>
                                    </form>
                                @elseif($title == 'Pencari Kos')
                                    @if ($currentUser->tenant && $currentUser->tenant->room && $currentUser->tenant->room->boardingHouse)
                                        <div class="text-start">
                                            <span class="badge bg-success">
                                                <i class="fa-solid fa-house-user me-1"></i>
                                                {{ $currentUser->tenant->room->boardingHouse->name }}
                                            </span>
                                            <br>
                                            <small class="text-muted">Kamar:
                                                {{ $currentUser->tenant->room->room_number }}</small>
                                        </div>
                                    @else
                                        <span class="badge bg-light text-dark border">Belum ada Kos</span>
                                    @endif
                                @elseif($title == 'Pemilik Kost')
                                    @if ($currentUser->boardingHouse)
                                        <small class="text-muted">
                                            <i class="fa-solid fa-location-dot me-1"></i>
                                            {{ $currentUser->boardingHouse->address }}
                                        </small>
                                    @else
                                        <span class="text-danger small">Kos belum didaftarkan</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    @if (count($users) == 0)
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

        </div>
    </div>
@endsection
