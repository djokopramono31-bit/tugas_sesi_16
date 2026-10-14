
@extends('layouts.app')

@section('title', 'Dashboard - My Shop')

@section('content')
<div class="content-card">
    <h1 class="mb-4">Dashboard</h1>
    <p>Selamat datang di halaman administrasi My Shop.</p>

    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="card border-0 bg-primary text-white p-4 text-center">
                <h5>Total Produk</h5>
                <h2>{{ $totalProduk }}</h2>
                <a href="{{ route('products.index') }}"
                   class="text-white">Lihat Produk</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 bg-dark text-white p-4 text-center">
                <h5>Total Kategori</h5>
                <h2>{{ $totalKategori }}</h2>
                <a href="{{ route('categories.index') }}"
                   class="text-white">Lihat Kategori</a>
            </div>
        </div>
    </div>
</div>
@endsection
