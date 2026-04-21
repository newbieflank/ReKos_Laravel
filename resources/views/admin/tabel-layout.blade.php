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
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user['id'] }}</td>
                            <td>{{ $user['name'] }}</td>
                            <td>{{ $user['phone'] }}</td>
                            <td>{{ $user['date'] }}</td>
                            <td>{{ $user['instansi'] }}</td>
                            <td class="text-center text-nowrap">
                                <button class="btn btn-soft-success rounded-pill px-3 py-1 me-1 border-0">Setuju</button>
                                <button class="btn btn-soft-danger rounded-pill px-3 py-1 border-0">Tidak</button>
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
