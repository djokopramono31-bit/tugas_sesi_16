
@extends('layouts.app')

@section('title', 'List Kategori - My Shop')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center
                flex-wrap gap-3 mb-4">
        <h1 class="mb-0">Daftar Kategori Produk</h1>

        <a href="{{ route('categories.create') }}"
           class="btn btn-primary btn-lg">
            Tambah Kategori
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->products_count }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('categories.edit', $category) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('categories.destroy', $category) }}"
                                  method="POST" class="d-inline"
                                  data-confirm-delete
                                  data-confirm-message="Yakin hapus kategori ini?">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada data kategori.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
