
@extends('layouts.app')

@section('title', 'Form Produk - My Shop')

@section('content')
<div class="content-card">
    <h1 class="mb-4">
        {{ $product->exists ? 'Edit Produk' : 'Tambah Produk' }}
    </h1>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ $product->exists
              ? route('products.update', $product)
              : route('products.store') }}">

        @csrf

        @if($product->exists)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Kategori Produk</label>
            <select name="product_category_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        @selected(old(
                            'product_category_id',
                            $product->product_category_id
                        ) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control"
                      rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stock" min="0"
                   class="form-control"
                   value="{{ old('stock', $product->stock ?? 0) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga (Rp)</label>
            <input type="number" name="price" min="0"
                   class="form-control"
                   value="{{ old('price', $product->price) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk</label>
            <input type="file" name="image"
                   class="form-control" accept="image/*">

            @if($product->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="Gambar produk"
                         width="150">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('products.index') }}"
           class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
