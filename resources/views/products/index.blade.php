
@extends('layouts.app')

@section('title', 'List Produk - My Shop')

@section('content')
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center
                flex-wrap gap-3 mb-4">
        <h1 class="mb-0">Daftar Produk</h1>

        <a href="{{ route('products.create') }}"
           class="btn btn-primary btn-lg">
            Tambah Produk
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            {{ $product->name }}
                            <div class="small text-muted">
                                {{ $product->category?->name ?? 'Tanpa kategori' }}
                            </div>
                        </td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->image)
                                <img
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-image">
                            @else
                                <div class="product-image d-flex
                                            align-items-center justify-content-center
                                            text-secondary">
                                    150 x 150
                                </div>
                            @endif
                        </td>
                        <td class="text-nowrap">
                            <a href="{{ route('products.edit', $product) }}"
                               class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('products.destroy', $product) }}"
                                  method="POST" class="d-inline"
                                  data-confirm-delete
                                  data-confirm-message="Yakin hapus produk ini?">
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
                        <td colspan="7" class="text-center">
                            Belum ada data produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
