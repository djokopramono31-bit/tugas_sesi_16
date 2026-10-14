
@extends('layouts.app')

@section('title', 'Form Kategori - My Shop')

@section('content')
<div class="content-card">
    <h1 class="mb-4">
        {{ $category->exists ? 'Edit Kategori' : 'Tambah Kategori' }}
    </h1>

    <form method="POST"
          action="{{ $category->exists
              ? route('categories.update', $category)
              : route('categories.store') }}">
        @csrf

        @if($category->exists)
            @method('PUT')
        @endif

        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name"
                   class="form-control"
                   value="{{ old('name', $category->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control"
                      rows="4">{{ old('description', $category->description) }}</textarea>
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('categories.index') }}"
           class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
